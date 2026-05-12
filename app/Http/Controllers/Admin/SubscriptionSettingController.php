<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.subscription-settings', [
            'price' => AppSetting::subscriptionPrice(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'price' => ['required', 'integer', 'min:1000', 'max:10000000'],
        ]);

        AppSetting::setSubscriptionPrice($validated['price']);

        return redirect()
            ->route('admin.subscription-settings.edit')
            ->with('success', 'Harga langganan berhasil diperbarui.');
    }
}
