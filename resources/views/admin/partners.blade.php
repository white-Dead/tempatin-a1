<x-layouts.admin>
    <x-slot name="title">Data Mitra</x-slot>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600">Nama Bisnis</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden md:table-cell">Pemilik</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600">Status</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden lg:table-cell">Berlangganan s/d</th>
                    <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden md:table-cell">Jumlah Tempat</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse(\App\Models\Partner::with(['user', 'places'])->latest()->paginate(20) as $partner)
                    <tr class="hover:bg-slate-50">
                        <td class="px-5 py-4">
                            <p class="font-medium text-slate-700">{{ $partner->business_name }}</p>
                            <p class="text-xs text-slate-400">{{ $partner->contact_phone }}</p>
                        </td>
                        <td class="px-5 py-4 text-slate-500 hidden md:table-cell">{{ $partner->user->full_name }}</td>
                        <td class="px-5 py-4">
                            @switch($partner->status)
                                @case('active')   <span class="badge-active">Aktif</span> @break
                                @case('pending')  <span class="badge-pending">Pending</span> @break
                                @case('rejected') <span class="badge-inactive">Ditolak</span> @break
                            @endswitch
                        </td>
                        <td class="px-5 py-4 text-slate-400 text-xs hidden lg:table-cell">
                            {{ $partner->subscription_expires_at?->format('d M Y') ?? '—' }}
                        </td>
                        <td class="px-5 py-4 text-slate-500 hidden md:table-cell">{{ $partner->places->count() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-slate-400">Belum ada mitra.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>
