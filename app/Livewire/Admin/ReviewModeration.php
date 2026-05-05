<?php

namespace App\Livewire\Admin;

use App\Models\Review;
use Livewire\Component;
use Livewire\WithPagination;

class ReviewModeration extends Component
{
    use WithPagination;

    public string $filter = 'pending';

    public function approve(int $reviewId): void
    {
        Review::findOrFail($reviewId)->update(['is_verified' => true]);
    }

    public function reject(int $reviewId): void
    {
        Review::findOrFail($reviewId)->delete();
    }

    public function render()
    {
        $reviews = Review::with(['user', 'place'])
            ->when($this->filter === 'pending', fn($q) => $q->where('is_verified', false))
            ->when($this->filter === 'approved', fn($q) => $q->where('is_verified', true))
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('livewire.admin.review-moderation', compact('reviews'));
    }
}
