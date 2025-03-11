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
            'user_id'         => Auth::id(),
            'device_id'       => $request->device_id ?? null,
            'transaction_id'  => $request->transaction_id ?? null,
            'activity'        => $request->activity,
        ]);

        return response()->json(['message' => 'Log activity saved', 'data' => $log], 201);
    }

    public function index()
    {
        $logs = LogActivity::where('user_id', Auth::id())->latest()->get();
        return response()->json(['data' => $logs], 200);
    }

    public function show($id)
    {
        $log = LogActivity::where('user_id', Auth::id())->findOrFail($id);
        return response()->json(['data' => $log], 200);
    }
}
