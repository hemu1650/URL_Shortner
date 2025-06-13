<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Company;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AdminInviteController extends Controller
{

    public function superadminDashboard()
    {
        // Get all admin users and load their company users (admin + members)
        $adminUsers = \App\Models\User::where('role', 'admin')
            ->with(['companyUsers' => function ($q) {
                $q->withCount('shortUrls')->withSum('shortUrls', 'hits');
            }])
            ->paginate(10); // Paginate admin users

        // Transform paginated data
        $clients = $adminUsers->getCollection()->map(function ($admin) {
            $totalUrls = $admin->companyUsers->sum('short_urls_count');
            $totalHits = $admin->companyUsers->sum('short_urls_sum_hits');

            return (object)[
                'company_name' => $admin->company_name ?? $admin->name,
                'email' => $admin->email,
                'members_count' => $admin->companyUsers->where('role', 'member')->count(),
                'total_urls' => $totalUrls,
                'total_hits' => $totalHits,
            ];
        });

        // Replace the original collection with the mapped one
        $clientsPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $clients,
            $adminUsers->total(),
            $adminUsers->perPage(),
            $adminUsers->currentPage(),
            [
                'path' => request()->url(),
                'query' => request()->query(),
            ]
        );

        // Load recent URLs
        $urls = \App\Models\ShortUrl::with('user')->latest()->paginate(10);

        return view('superadmin.superadmin', compact('clientsPaginated', 'urls'));
    }

    public function create()
    {
        return view('superadmin.invite');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'company_name' => 'required'
        ]);

        $company = Company::create(['name' => $request->company_name]);

        // Create user with a random temp password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(Str::random(10)), // Temporary password
            'role' => 'admin',
            'company_id' => $company->id,
        ]);

        // Send password reset link
        Password::sendResetLink(['email' => $user->email]);

        return redirect()->back()->with('success', 'Admin invited successfully. A password setup link has been sent to their email.');
    }

    public function exportCsv(Request $request)
    {
        dd(1);
        $filter = $request->input('filter');

        $admins = User::where('role', 'admin')
            ->with(['users.shortUrls' => function ($query) use ($filter) {
                if ($filter) {
                    $dateRange = match ($filter) {
                        'today' => [Carbon::today(), Carbon::today()->endOfDay()],
                        'last_week' => [
                            Carbon::now()->subWeek()->startOfWeek(),
                            Carbon::now()->subWeek()->endOfWeek()
                        ],
                        'this_month' => [
                            Carbon::now()->startOfMonth(),
                            Carbon::now()->endOfMonth()
                        ],
                        'last_month' => [
                            Carbon::now()->subMonth()->startOfMonth(),
                            Carbon::now()->subMonth()->endOfMonth()
                        ],
                        default => null
                    };

                    if ($dateRange) {
                        $query->whereBetween('created_at', $dateRange);
                    }
                }
            }])->get();

        $csvHeader = ['Company Name', 'Email', 'Members Count', 'Total URLs', 'Total Hits'];
        $csvData = [];

        foreach ($admins as $admin) {
            $members = $admin->users ?? collect();
            $totalUrls = $members->sum(fn($user) => $user->shortUrls->count());
            $totalHits = $members->sum(fn($user) => $user->shortUrls->sum('hits'));

            $csvData[] = [
                $admin->company_name ?? $admin->name,
                $admin->email,
                $members->count(),
                $totalUrls,
                $totalHits,
            ];
        }

        $filename = 'clients_export_' . now()->format('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ]);
    }

    public function clientList()
    {
        $adminUsers = \App\Models\User::where('role', 'admin')
            ->with(['companyUsers' => function ($q) {
                $q->withCount('shortUrls')->withSum('shortUrls', 'hits');
            }])
            ->paginate(10); // Keep pagination

        // Transform the paginated collection
        $transformed = $adminUsers->getCollection()->map(function ($admin) {
            $totalUrls = $admin->companyUsers->sum('short_urls_count');
            $totalHits = $admin->companyUsers->sum('short_urls_sum_hits');

            return (object)[
                'company_name' => $admin->company_name ?? $admin->name,
                'email' => $admin->email,
                'members_count' => $admin->companyUsers->where('role', 'member')->count(),
                'total_urls' => $totalUrls,
                'total_hits' => $totalHits,
            ];
        });

        // Replace the collection inside paginator
        $adminUsers->setCollection($transformed);

        // Pass paginated data to view
        return view('superadmin.clients.index', ['clients' => $adminUsers]);
    }



    public function exportShortUrls(Request $request)
    {
        $range = $request->input('range');
        $query = ShortUrl::with('user');

        $now = Carbon::now();

        switch ($range) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                break;
            case 'last_week':
                $query->whereBetween('created_at', [
                    $now->copy()->subWeek()->startOfWeek(),
                    $now->copy()->subWeek()->endOfWeek()
                ]);
                break;
            case 'last_month':
                $query->whereMonth('created_at', $now->copy()->subMonth()->month)
                    ->whereYear('created_at', $now->copy()->subMonth()->year);
                break;
            case 'this_month':
                $query->whereMonth('created_at', $now->month)
                    ->whereYear('created_at', $now->year);
                break;
            default:
                return redirect()->back()->with('error', 'Please select a valid range.');
        }

        $urls = $query->get();

        $filename = 'short_urls_' . $range . '_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($urls) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Short URL', 'Original URL', 'Created By', 'Role', 'Created At']);

            foreach ($urls as $url) {
                fputcsv($file, [
                    url('/' . $url->short_code),
                    $url->original_url,
                    $url->user->name ?? 'N/A',
                    $url->user->role ?? 'N/A',
                    $url->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    public function urlsIndex()
    {
        $urls = ShortUrl::with('user')->latest()->paginate(25);

        return view('superadmin.urls.index', compact('urls'));
    }


}
