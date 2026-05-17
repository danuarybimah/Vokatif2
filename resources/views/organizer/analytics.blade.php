@extends('layouts.dashboard')

@section('content')
<div class="space-y-10">

    <!-- HEADER -->
    <div>
        <h1 class="text-5xl font-black">Analytics</h1>
        <p class="text-slate-400 mt-3">Performa event dan penjualan tiket kamu.</p>
    </div>

    <!-- STATS -->
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="gradient-card rounded-3xl p-6">
            <p class="text-white/70 text-sm">Total Revenue</p>
            <h2 class="text-3xl font-black mt-3">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </h2>
        </div>

        <div class="glass rounded-3xl p-6">
            <p class="text-slate-400 text-sm">Total Orders</p>
            <h2 class="text-5xl font-black mt-3">{{ $totalOrders }}</h2>
            <p class="text-xs text-slate-500 mt-2">
                <span class="text-emerald-400">{{ $paidOrders }} paid</span>
                · <span class="text-yellow-400">{{ $pendingOrders }} pending</span>
            </p>
        </div>

        <div class="glass rounded-3xl p-6">
            <p class="text-slate-400 text-sm">Total Events</p>
            <h2 class="text-5xl font-black mt-3">{{ $totalEvents }}</h2>
            <p class="text-xs text-emerald-400 mt-2">{{ $publishedEvents }} published</p>
        </div>

        <div class="glass rounded-3xl p-6">
            <p class="text-slate-400 text-sm">Conversion Rate</p>
            <h2 class="text-5xl font-black mt-3">
                {{ $totalOrders > 0 ? round(($paidOrders / $totalOrders) * 100) : 0 }}%
            </h2>
            <p class="text-xs text-slate-500 mt-2">paid / total orders</p>
        </div>

    </div>

    <!-- CHARTS -->
    <div class="grid lg:grid-cols-2 gap-6">

        <div class="glass rounded-3xl p-8">
            <h2 class="text-2xl font-black mb-2">Revenue per Bulan</h2>
            <p class="text-slate-400 text-sm mb-6">12 bulan terakhir</p>
            <canvas id="revenueChart" height="130"></canvas>
        </div>

        <div class="glass rounded-3xl p-8">
            <h2 class="text-2xl font-black mb-2">Tiket Terjual per Bulan</h2>
            <p class="text-slate-400 text-sm mb-6">12 bulan terakhir</p>
            <canvas id="ticketsChart" height="130"></canvas>
        </div>

    </div>

    <!-- TOP EVENTS -->
    <div class="glass rounded-3xl p-8">
        <h2 class="text-2xl font-black mb-6">Top 5 Events by Revenue</h2>
        <div class="space-y-4">
            @forelse($topEvents as $i => $event)
            <div class="glass rounded-2xl p-5 flex items-center justify-between">
                <div class="flex items-center gap-5">
                    <span class="w-10 h-10 rounded-full gradient-card flex items-center justify-center font-black text-lg">
                        {{ $i + 1 }}
                    </span>
                    <div>
                        <h3 class="font-black text-lg">{{ $event->title }}</h3>
                        <p class="text-slate-400 text-sm">{{ $event->orders_count }} orders · {{ $event->city }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-fuchsia-400 font-black text-xl">
                        Rp{{ number_format($event->revenue ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="text-center text-slate-400 py-8">Belum ada data event.</div>
            @endforelse
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
const months = @json($months);
const chartDefaults = {
    responsive: true,
    plugins: { legend: { labels: { color: '#fff' } } },
    scales: {
        x: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } },
        y: { ticks: { color: '#94a3b8' }, grid: { color: 'rgba(255,255,255,0.05)' } }
    }
};

new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{ label: 'Revenue', data: @json($monthlyRevenue), borderColor: '#d946ef', backgroundColor: 'rgba(217,70,239,0.15)', fill: true, tension: 0.4 }]
    },
    options: chartDefaults
});

new Chart(document.getElementById('ticketsChart'), {
    type: 'bar',
    data: {
        labels: months,
        datasets: [{ label: 'Tickets Sold', data: @json($monthlyTickets), backgroundColor: '#8b5cf6', borderRadius: 8 }]
    },
    options: chartDefaults
});
</script>
@endpush
