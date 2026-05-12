<x-layouts.admin>
    <x-slot name="title">Pengaturan Langganan</x-slot>

    <div class="max-w-2xl">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-slate-700">Harga Langganan Premium</h2>
            <p class="mt-2 text-sm text-slate-500">
                Atur harga paket premium bulanan yang tampil di halaman Langganan pengguna.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.subscription-settings.update') }}" class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
            @csrf
            @method('PUT')

            <label for="price" class="input-label">Harga per bulan</label>
            <div class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-slate-400">Rp</span>
                    <input id="price"
                           name="price"
                           type="number"
                           min="1000"
                           step="1000"
                           value="{{ old('price', $price) }}"
                           class="input pl-11">
                </div>
                <button type="submit" class="btn-primary justify-center">
                    Simpan Harga
                </button>
            </div>

            @error('price')
                <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
            @enderror

            <p class="mt-4 text-sm text-slate-400">
                Harga saat ini: Rp {{ number_format($price, 0, ',', '.') }} per bulan.
            </p>
        </form>
    </div>
</x-layouts.admin>
