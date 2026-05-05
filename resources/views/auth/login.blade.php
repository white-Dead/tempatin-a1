<x-layouts.guest>
    <x-slot name="title">Masuk</x-slot>

    <h1 class="text-2xl font-bold text-slate-700 mb-1">Selamat datang kembali</h1>
    <p class="text-slate-400 text-sm mb-7">Masuk untuk mengakses fitur lengkap Tempatin.</p>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label class="input-label">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="input @error('email') border-rose-300 focus:ring-rose-400 focus:border-rose-400 @enderror"
                   placeholder="email@contoh.com">
            @error('email')
                <p class="text-rose-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="input-label">Password</label>
            <input type="password" name="password" required
                   class="input"
                   placeholder="••••••••">
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-500 cursor-pointer">
                <input type="checkbox" name="remember"
                       class="rounded text-brand-500 border-slate-300 focus:ring-brand-400 focus:ring-offset-0">
                Ingat saya
            </label>
        </div>

        <button type="submit" class="btn-primary w-full justify-center py-3">
            Masuk
        </button>
    </form>

    <p class="text-center text-sm text-slate-400 mt-6">
        Belum punya akun?
        <a href="{{ route('register') }}" class="text-brand-600 font-semibold hover:text-brand-700">Daftar sekarang</a>
    </p>
</x-layouts.guest>
