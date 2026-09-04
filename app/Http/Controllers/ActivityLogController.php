<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer')->latest();

        // Filter pencarian
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('log_name', 'like', "%{$search}%")
                  ->orWhereHas('causer', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan log_name (modul)
        if ($request->filled('module')) {
            $query->where('log_name', $request->input('module'));
        }

        // Filter berdasarkan event/description
        if ($request->filled('event')) {
            $query->where('description', $request->input('event'));
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $activities = $query->paginate(25)->withQueryString();

        // Ambil daftar modul unik untuk filter dropdown
        $modules = Activity::select('log_name')->distinct()->orderBy('log_name')->pluck('log_name');

        return view('admin.activity_logs.index', compact('activities', 'modules'));
    }
}
