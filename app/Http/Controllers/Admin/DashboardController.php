<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Place;
use App\Models\Review;
use App\Models\User;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_places'          => Place::count(),
            'active_places'         => Place::where('status', 'active')->count(),
            'pending_places'        => Place::where('status', 'pending_review')->count(),
            'total_reviews'         => Review::count(),
            'pending_reviews'       => Review::where('is_verified', false)->count(),
            'total_users'           => User::where('role', 'user')->count(),
            'total_partners'        => User::whereIn('role', ['partner', 'partner_admin'])->count(),
            'views_today'           => ActivityLog::whereDate('created_at', today())
                                        ->where('action_type', 'view_profile')->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
