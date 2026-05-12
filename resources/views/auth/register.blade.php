<x-layouts.guest>
    <x-slot name="title">Daftar Akun</x-slot>

    <h1 class="text-2xl font-bold text-slate-700 mb-1">Buat Akun Baru</h1>
    <p class="text-slate-400 text-sm mb-7">Bergabung dan temukan tempat produktif terbaikmu.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <div>
            <label class="input-label">Nama Lengkap <span class="text-rose-400">*</span></label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" required autofocus
                   class="input @error('full_name') border-rose-300 @enderror"
                   placeholder="Nama Lengkap Kamu">
            @error('full_name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="input-label">Email <span class="text-rose-400">*</span></label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="input @error('email') border-rose-300 @enderror"
                   placeholder="email@contoh.com">
            @error('email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="input-label">No. HP (opsional)</label>
            <input type="tel" name="phone" value="{{ old('phone') }}"
                   class="input"
                   placeholder="08xxxxxxxxxx">
        </div>

        <div>
            <label class="input-label">Daftar sebagai</label>
            <div class="flex gap-3 mt-2">
                <label class="inline-flex items-center gap-2">
                    <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }}>
                    <span class="text-sm">Pengguna</span>
                </label>
                <label class="inline-flex items-center gap-2">
                    <input type="radio" name="role" value="partner" {{ old('role') === 'partner' ? 'checked' : '' }}>
                    <span class="text-sm">Mitra (pemilik tempat)</span>
                </label>
            </div>
        </div>
        <div>
            <label class="input-label">Password <span class="text-rose-400">*</span></label>
            <input type="password" name="password" required
                   class="input @error('password') border-rose-300 @enderror"
                   placeholder="Minimal 8 karakter">
            @error('password') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="input-label">Konfirmasi Password <span class="text-rose-400">*</span></label>
            <input type="password" name="password_confirmation" required
                   class="input"
                   placeholder="Ulangi password">
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3">
            Buat Akun
        </button>
    </form>

    <p class="text-center text-sm text-slate-400 mt-6">
        Sudah punya akun?
        <a href="{{ route('login') }}" class="text-brand-600 font-semibold hover:text-brand-700">Masuk</a>
    </p>
</x-layouts.guest>
