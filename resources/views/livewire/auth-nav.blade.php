<div>
@auth
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open"
                class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-slate-50 transition-colors">
            <div class="w-8 h-8 bg-brand-100 rounded-full flex items-center justify-center">
                <span class="text-brand-700 font-semibold text-sm">
                    {{ substr(auth()->user()->full_name, 0, 1) }}
                </span>
            </div>
            <span class="hidden md:block text-sm font-medium text-slate-600">
                {{ auth()->user()->full_name }}
            </span>
            <svg class="w-4 h-4 text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"
                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <div x-show="open" x-transition @click.outside="open = false"
             class="absolute right-0 mt-2 w-52 bg-white border border-slate-100 rounded-2xl shadow-lg py-2 z-50">

            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" wire:navigate
                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600">
                    Panel Admin
                </a>
            @endif

            @if(auth()->user()->isPartner())
                <a href="{{ route('partner.dashboard') }}" wire:navigate
                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 hover:bg-brand-50 hover:text-brand-600">
                    Dashboard Mitra
                </a>
            @endif

            <div class="border-t border-slate-100 my-1"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 px-4 py-2.5 text-sm text-rose-500 hover:bg-rose-50 text-left">
                    Keluar
                </button>
            </form>
        </div>
    </div>
@else
    <div class="flex items-center gap-2">
        <a href="{{ route('login') }}" wire:navigate class="btn-ghost text-sm">Masuk</a>
        <a href="{{ route('register') }}" wire:navigate class="btn-primary text-sm py-2">Daftar</a>
    </div>
@endauth
</div>
