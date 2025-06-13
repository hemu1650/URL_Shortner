<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;


class ShortUrlController extends Controller
{

    public function index(Request $request)
    {
        if (Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot create URLs');
        }
        $user = Auth::user();
        $query = ShortUrl::query()->with('user');

        // Role-based filtering
        if ($user->role === 'superadmin') {
            // no filter
        } elseif ($user->role === 'admin') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('company_id', $user->company_id);
            });
        } else {
            $query->where('user_id', $user->id);
        }

        // Date Interval Filter
        if ($request->has('interval')) {
            switch ($request->interval) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                        ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // $urls = $query->orderByDesc('created_at')->get();
        $urls = $query->orderByDesc('created_at')->paginate(10); // ✅ use paginate


        return view('urls.index', compact('urls'));
    }

    public function create()
    {
        if (Auth::user()->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot create URLs');
        }

        return view('urls.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortCode = Str::random(6);

        ShortUrl::create([
            'user_id' => Auth::id(),
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
        ]);

        return redirect()->route('urls.index')->with('success', 'Short URL created');
    }

    public function redirect($code)
    {
        $shortUrl = ShortUrl::where('short_code', $code)->firstOrFail();

        // Increment the hit counter
        $shortUrl->increment('hits');

        // Redirect to the original URL
        return redirect($shortUrl->original_url);
    }


    public function download(Request $request)
    {
        $user = Auth::user();
        $query = ShortUrl::query()->with('user');

        if ($user->role === 'superadmin') {
            // no filter
        } elseif ($user->role === 'admin') {
            $query->whereHas('user', function ($q) use ($user) {
                $q->where('company_id', $user->company_id);
            });
        } else {
            $query->where('user_id', $user->id);
        }

        // Same interval filtering as index
        if ($request->has('interval')) {
            switch ($request->interval) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'last_week':
                    $query->whereBetween('created_at', [
                        Carbon::now()->subWeek()->startOfWeek(),
                        Carbon::now()->subWeek()->endOfWeek()
                    ]);
                    break;
                case 'last_month':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                        ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
                case 'this_month':
                    $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
                    break;
            }
        }

        // $urls = $query->get();
        // $urls = $query->paginate(10); // Or any number of items per page
        $urls = $query->orderByDesc('created_at')->paginate(10);



        $filename = 'short_urls_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($urls) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Short URL', 'Original URL', 'Created By', 'Hits', 'Created At']);

            foreach ($urls as $url) {
                fputcsv($file, [
                    url('/' . $url->short_code),
                    $url->original_url,
                    $url->user->name ?? '',
                    $url->hits ?? 0,
                    $url->created_at->format('d M Y'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }


}
