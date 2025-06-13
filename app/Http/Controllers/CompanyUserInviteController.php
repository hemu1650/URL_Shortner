<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\ShortUrl;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class CompanyUserInviteController extends Controller
{
    /**
     * Show the form to invite a new member.
     */

    public function dashboard()
    {
        if (Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot access');
        }
        $admin = auth()->user();

        // Get all member IDs under this admin
        $memberIds = $admin->users()->pluck('id')->toArray();
        $memberIds[] = $admin->id; // Include admin's own ID

        // Get all users (admin + members) with URL stats
        $members = User::whereIn('id', $memberIds)
            ->withCount('shortUrls')
            ->withSum('shortUrls', 'hits')
            ->paginate(10);

        // Summary
        $clients = (object)[
            'company_name' => $admin->company_name ?? $admin->name,
            'email' => $admin->email,
            'members_count' => $members->total(),
            'total_urls' => $members->total() > 0 ? $members->sum('short_urls_count') : 0,
            'total_hits' => $members->total() > 0 ? $members->sum('short_urls_sum_hits') : 0,
        ];

        // Latest short URLs (admin + members)
        $urls = ShortUrl::whereIn('user_id', $memberIds)
            ->with('user')
            ->latest()
            ->paginate(10);

        return view('admin.dashboard', compact('clients', 'members', 'urls'));
    }


    
    public function membersList()
    {
        if (Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot access');
        }
        $admin = auth()->user();

        // Include admin + members
        $memberIds = $admin->users()->pluck('id')->toArray();
        $memberIds[] = $admin->id;

        $members = User::whereIn('id', $memberIds)
            ->with('shortUrls')
            ->paginate(20);

        return view('admin.members.index', compact('members'));
    }


    public function urls(Request $request)
    {
        if (Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot access');
        }

        $admin = auth()->user();

        // Get all member IDs under this admin
        $memberIds = $admin->users()->pluck('id')->toArray();

        // Include admin's own ID
        $allUserIds = array_merge($memberIds, [$admin->id]);

        // Get Short URLs for both admin and their members
        $urls = ShortUrl::whereIn('user_id', $allUserIds)
                        ->with('user')
                        ->latest()
                        ->paginate(20);

        return view('admin.urls.index', compact('urls'));
    }



    public function create()
    {
        if (Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot access');
        }
        return view('admin.invite');
    }

    /**
     * Store the invited member to the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:admin,member',
        ]);

        $admin = Auth::user();

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => bcrypt($request->password),
            'role'       => $request->role,  // Now using dropdown role
            'company_id' => $admin->company_id,
        ]);

        return redirect()->back()->with('success', 'User invited successfully as ' . ucfirst($request->role) . '.');
    }



    public function exportUrls(Request $request)
    {
        $admin = auth()->user();

        $range = $request->input('range');
        $dateRange = match ($range) {
            'today' => [Carbon::today(), Carbon::tomorrow()],
            'last_week' => [Carbon::now()->subWeek(), Carbon::now()],
            'last_month' => [Carbon::now()->subMonth(), Carbon::now()],
            'this_month' => [Carbon::now()->startOfMonth(), Carbon::now()],
            default => null,
        };

        if (!$dateRange) {
            return redirect()->back()->with('error', 'Invalid date range selected.');
        }

        // Get member IDs
        $memberIds = $admin->users()->pluck('id');

        $urls = ShortUrl::whereIn('user_id', $memberIds)
            ->whereBetween('created_at', $dateRange)
            ->with('user')
            ->get();

        $csvHeader = ['Short Code', 'Original URL', 'Created At', 'Created By'];

        $csvData = $urls->map(function ($url) {
            return [
                $url->short_code,
                $url->original_url,
                $url->created_at->format('Y-m-d H:i:s'),
                $url->user->name ?? 'N/A',
            ];
        });

        $filename = 'urls_export_' . now()->format('Ymd_His') . '.csv';
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



}
