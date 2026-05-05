<x-layouts.app>
    <x-slot name="title">Jelajah Tempat</x-slot>

    <div class="bg-gradient-to-b from-orange-50 to-white py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-slate-700 mb-1">Jelajah Tempat Produktif</h1>
            <p class="text-slate-500">Filter dan temukan tempat yang paling cocok dengan kebutuhanmu.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <livewire:place-search />
    </div>
</x-layouts.app>
