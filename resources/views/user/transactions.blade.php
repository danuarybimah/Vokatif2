@extends('layouts.user')

@section('content')
<div class="space-y-8">

    <div>
        <h1 class="text-5xl font-black">Riwayat Transaksi</h1>
        <p class="text-slate-400 mt-3">Semua riwayat pembelian tiket kamu.</p>
    </div>

    <!-- BACK BUTTON -->
        @php $role = auth()->user()?->role?->slug; @endphp
        <div class="mb-8">
            <a href="{{ $role === 'admin' ? '/admin/dashboard' : ($role === 'organizer' ? '/organizer/dashboard' : '/home') }}"
                class="inline-flex items-center gap-2 text-slate-400 hover:text-white transition font-bold">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke {{ $role === 'admin' ? 'Dashboard' : ($role === 'organizer' ? 'Dashboard' : 'Home') }}
            </a>
        </div>

    <!-- SUMMARY -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-sm">Total Transaksi</p>
            <h2 class="text-4xl font-black mt-2">{{ $orders->count() }}</h2>
        </div>
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-sm">Total Bayar</p>
            <h2 class="text-2xl font-black mt-2 text-cyan-400">
                Rp{{ number_format($orders->where('payment_status','paid')->sum('total_amount'), 0, ',', '.') }}
            </h2>
        </div>
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-sm">Paid</p>
            <h2 class="text-4xl font-black mt-2 text-emerald-400">
                {{ $orders->where('payment_status','paid')->count() }}
            </h2>
        </div>
        <div class="glass rounded-2xl p-5">
            <p class="text-slate-400 text-sm">Pending</p>
            <h2 class="text-4xl font-black mt-2 text-yellow-400">
                {{ $orders->where('payment_status','pending')->count() }}
            </h2>
        </div>
    </div>

    <!-- TABLE -->
    <div class="glass rounded-[32px] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="border-b border-white/10 bg-white/5">
                    <tr>
                        <th class="text-left px-8 py-5 text-slate-400 font-bold">Event</th>
                        <th class="text-left px-8 py-5 text-slate-400 font-bold">Tiket</th>
                        <th class="text-left px-8 py-5 text-slate-400 font-bold">Total</th>
                        <th class="text-left px-8 py-5 text-slate-400 font-bold">Status</th>
                        <th class="text-left px-8 py-5 text-slate-400 font-bold">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-b border-white/5 hover:bg-white/5 transition">
                            <td class="px-8 py-5">
                                <p class="font-black">{{ $order->event->title }}</p>
                                <p class="text-slate-400 text-sm mt-1">{{ $order->event->city }}</p>
                            </td>
                            <td class="px-8 py-5 text-cyan-400 font-bold">
                                {{ $order->tickets->first()?->ticketType->name ?? '-' }}
                            </td>
                            <td class="px-8 py-5 font-black">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>
                            <td class="px-8 py-5">
                                @if($order->payment_status === 'paid')
                                    <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 text-sm font-bold">Paid</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-yellow-500/20 text-yellow-400 text-sm font-bold">Pending</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 text-slate-400">
                                {{ $order->created_at->format('d M Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-16 text-slate-400">
                                Belum ada transaksi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
