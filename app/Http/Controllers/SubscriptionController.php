<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        return view('subscriptions.index', [
            'price' => AppSetting::subscriptionPrice(),
        ]);
    }

    public function activate(): RedirectResponse
    {
        $user = auth()->user();
        $startsAt = $user->premium_ends_at?->isFuture()
            ? $user->premium_ends_at
            : now();

        $user->update([
            'premium_ends_at' => $startsAt->copy()->addMonth(),
        ]);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Langganan premium aktif selama 1 bulan.');
    }

    public function cancel(): RedirectResponse
    {
        auth()->user()->update([
            'premium_ends_at' => null,
        ]);

        return redirect()
            ->route('subscriptions.index')
            ->with('success', 'Langganan premium berhasil dihentikan.');
    }
}
