<?php

namespace App\Livewire\Admin;

use App\Models\ActivityLog;
use App\Models\Review;
use Livewire\Component;

class DashboardStats extends Component
{
    public function render()
    {
        $topPlaces = ActivityLog::selectRaw('place_id, COUNT(*) as total_views')
            ->where('action_type', 'view_profile')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy('place_id')
            ->orderByDesc('total_views')
            ->with('place:place_id,place_name,city')
            ->limit(5)
            ->get();

        $recentReviews = Review::with(['user:user_id,full_name', 'place:place_id,place_name'])
            ->where('is_verified', false)
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('livewire.admin.dashboard-stats', compact('topPlaces', 'recentReviews'));
    }
}
