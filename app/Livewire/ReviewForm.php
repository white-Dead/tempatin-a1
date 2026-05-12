<?php

namespace App\Livewire;

use App\Models\Review;
use Livewire\Component;

class ReviewForm extends Component
{
    public int $placeId;

    public int $ratingWifi = 0;

    public int $ratingComfort = 0;

    public int $ratingSocket = 0;

    public int $ratingOverall = 0;

    public string $comment = '';

    public bool $submitted = false;

    protected function rules(): array
    {
        return [
            'ratingWifi' => 'required|integer|min:1|max:5',
            'ratingComfort' => 'required|integer|min:1|max:5',
            'ratingSocket' => 'required|integer|min:1|max:5',
            'ratingOverall' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];
    }

    protected function messages(): array
    {
        return [
            'ratingWifi.min' => 'Rating WiFi harus diisi.',
            'ratingComfort.min' => 'Rating kenyamanan harus diisi.',
            'ratingSocket.min' => 'Rating stop kontak harus diisi.',
            'ratingOverall.min' => 'Rating keseluruhan harus diisi.',
        ];
    }

    public function setRating(string $field, int $value): void
    {
        $this->$field = $value;
    }

    public function submit(): void
    {
        if (! auth()->check()) {
            $this->dispatch('show-login-prompt');

            return;
        }

        $this->validate();

        $alreadyReviewed = Review::where('user_id', auth()->id())
            ->where('place_id', $this->placeId)
            ->exists();

        if ($alreadyReviewed) {
            $this->addError('general', 'Kamu sudah memberikan ulasan untuk tempat ini.');

            return;
        }

        Review::create([
            'user_id' => auth()->id(),
            'place_id' => $this->placeId,
            'rating_wifi' => $this->ratingWifi,
            'rating_comfort' => $this->ratingComfort,
            'rating_socket' => $this->ratingSocket,
            'rating_overall' => $this->ratingOverall,
            'comment' => $this->comment,
            'is_verified' => false,
        ]);

        $this->submitted = true;
        $this->dispatch('review-submitted');
    }

    public function render()
    {
        return view('livewire.review-form');
    }
}
