<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Support\Facades\Auth;

class LogActivityController extends Controller
{
    public function store(Request $request)
    {
        $log = LogActivity::create([
            'timestamp'       => now(),
            'user_id'        => Auth::id(),
            'device_id'      => $request->device_id ?? null,
            'transaction_id' => $request->transaction_id ?? null,
            'activity'       => $request->activity,
        ]);

        return response()->json(['message' => 'Log activity saved', 'data' => $log], 201);
    }

    /**
     * Display activity logs in admin view
     */
    public function adminIndex(Request $request)
    {
        $query = LogActivity::with(['user', 'device', 'transaction'])
            ->orderBy('timestamp', 'desc');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('activity', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('device', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Get paginated results
        $logs = $query->paginate(15);

        return view('admin.logActivity', [
            'logs' => $logs
        ]);
    }

    public function search(Request $request)
    {
        $query = LogActivity::with(['user', 'device', 'transaction'])
            ->orderBy('timestamp', 'desc');

        if ($request->get('query')) {
            $search = $request->get('query');
            $query->where(function($q) use ($search) {
                $q->where('activity', 'LIKE', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('device', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        $logs = $query->paginate(15);

        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.partials.log-table', ['logs' => $logs])->render(),
                'first_item' => $logs->firstItem() ?? 0,
                'last_item' => $logs->lastItem() ?? 0,
                'total' => $logs->total(),
                'pagination' => $logs->links()->render()
            ]);
        }

        return view('admin.logActivity', compact('logs'));
    }

    /**
     * Display user-specific logs (for API)
     */
    public function index()
    {
        $logs = LogActivity::where('user_id', Auth::id())
            ->with(['device', 'transaction'])
            ->latest()
            ->get();
        return response()->json(['data' => $logs], 200);
    }

    public function show($id)
    {
        $log = LogActivity::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['data' => $log], 200);
    }
}
