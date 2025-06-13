<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class DataMonitoringController extends Controller
{
    /**
     * Show sensor readings for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userID = $user->userID; // your PK column

        // 1) Get farmIDs for this user from user_farms pivot
        $farmIDs = DB::table('user_farms')
            ->where('userID', $userID)
            ->pluck('farmID')
            ->toArray();

        // 2) Get plotIDs for these farms
        $plotIDs = [];
        if (!empty($farmIDs)) {
            $plotIDs = DB::table('plots')
                ->whereIn('farmID', $farmIDs)
                ->pluck('plotID')
                ->toArray();
        }

        // 3) Count total plots
        $totalPlots = count($plotIDs);

        // 4) Build sensor_readings query filtered by plotIDs
        $readingsQuery = DB::table('sensor_readings')
            ->whereIn('plotID', $plotIDs)
            ->orderBy('created_at', 'desc');

        // Optional filtering by farm or plot from request
        if ($request->filled('farm')) {
            $farmId = (int)$request->input('farm');
            if (in_array($farmId, $farmIDs)) {
                $plotIDsForFarm = DB::table('plots')
                    ->where('farmID', $farmId)
                    ->pluck('plotID')
                    ->toArray();
                $readingsQuery->whereIn('plotID', $plotIDsForFarm);
            }
        }
        if ($request->filled('plot')) {
            $plotId = (int)$request->input('plot');
            if (in_array($plotId, $plotIDs)) {
                $readingsQuery->where('plotID', $plotId);
            }
        }

        // 5) Pagination setup
        $perPage = 20;
        $currentPage = $request->input('page', 1);
        $offset = ($currentPage - 1) * $perPage;

        $totalCount = $readingsQuery->count();
        $items = $readingsQuery
            ->offset($offset)
            ->limit($perPage)
            ->get();

        // Create LengthAwarePaginator instance
        $paginator = new LengthAwarePaginator(
            $items,
            $totalCount,
            $perPage,
            $currentPage,
            [
                'path'  => route('datamonitoring'),
                'query' => $request->query(),
            ]
        );

        // 6) Fetch farms and their plots for filter dropdowns
        $farms = DB::table('farms')
            ->whereIn('farmID', $farmIDs)
            ->get();
        // Build an array: farmID => collection of plots
        $farmPlots = [];
        foreach ($farms as $farm) {
            $plots = DB::table('plots')
                ->where('farmID', $farm->farmID)
                ->get();
            $farmPlots[$farm->farmID] = $plots;
        }

        // 7) Pass data to Blade
        return view('datamonitoring', [
            'readings'   => $paginator,
            'farms'      => $farms,
            'farmPlots'  => $farmPlots,
            'totalPlots' => $totalPlots,
        ]);
    }
}
