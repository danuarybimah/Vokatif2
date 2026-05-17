@extends('layouts.dashboard')

@section('content')
    <div class="space-y-10">

        <!-- HEADER -->
        <div>
            <h1 class="text-5xl font-black">Analytics</h1>
            <p class="text-slate-400 mt-3">Overview performa seluruh platform Vokatif.</p>
        </div>

        <!-- STATS -->
        <div class="grid grid-cols-2 xl:grid-cols-5 gap-6">

            <div class="glass rounded-3xl p-6">
                <p class="text-slate-400 text-sm">Total Revenue</p>
                <h2 class="text-3xl font-black mt-3 text-cyan-400">
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
                <p class="text-slate-400 text-sm">Total Users</p>
                <h2 class="text-5xl font-black mt-3">{{ $totalUsers }}</h2>
            </div>

            <div class="glass rounded-3xl p-6">
                <p class="text-slate-400 text-sm">Total Events</p>
                <h2 class="text-5xl font-black mt-3">{{ $totalEvents }}</h2>
            </div>

            <div class="glass rounded-3xl p-6">
                <p class="text-slate-400 text-sm">Total Organizers</p>
                <h2 class="text-5xl font-black mt-3">{{ $totalOrganizers }}</h2>
                <p class="text-xs text-slate-500 mt-2">active organizers</p>
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
                <h2 class="text-2xl font-black mb-2">Orders per Bulan</h2>
                <p class="text-slate-400 text-sm mb-6">12 bulan terakhir</p>
                <canvas id="ordersChart" height="130"></canvas>
            </div>

            <div class="glass rounded-3xl p-8 lg:col-span-2">
                <h2 class="text-2xl font-black mb-2">Registrasi User per Bulan</h2>
                <p class="text-slate-400 text-sm mb-6">12 bulan terakhir</p>
                <canvas id="usersChart" height="80"></canvas>
            </div>

        </div>

        <!-- TOP EVENTS -->
        <div class="glass rounded-3xl p-8">
            <h2 class="text-2xl font-black mb-6">Top 5 Events by Revenue</h2>
            <div class="space-y-4">
                @foreach ($topEvents as $i => $event)
                    <div class="glass rounded-2xl p-5 flex items-center justify-between">
                        <div class="flex items-center gap-5">
                            <span
                                class="w-10 h-10 rounded-full gradient-card flex items-center justify-center font-black text-lg">
                                {{ $i + 1 }}
                            </span>
                            <div>
                                <h3 class="font-black text-lg">{{ $event->title }}</h3>
                                <p class="text-slate-400 text-sm">{{ $event->orders_count }} orders</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-cyan-400 font-black text-xl">
                                Rp{{ number_format($event->revenue ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        const months = @json($months);
        const chartDefaults = {
            responsive: true,
            plugins: {
                legend: {
                    labels: {
                        color: '#fff'
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: '#94a3b8'
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.05)'
                    }
                },
                y: {
                    ticks: {
                        color: '#94a3b8'
                    },
                    grid: {
                        color: 'rgba(255,255,255,0.05)'
                    }
                }
            }
        };

        new Chart(document.getElementById('revenueChart'), {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Revenue',
                    data: @json($monthlyRevenue),
                    borderColor: '#06b6d4',
                    backgroundColor: 'rgba(6,182,212,0.15)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: chartDefaults
        });

        new Chart(document.getElementById('ordersChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Orders',
                    data: @json($monthlyOrders),
                    backgroundColor: '#8b5cf6',
                    borderRadius: 8
                }]
            },
            options: chartDefaults
        });

        new Chart(document.getElementById('usersChart'), {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'New Users',
                    data: @json($monthlyUsers),
                    backgroundColor: '#d946ef',
                    borderRadius: 8
                }]
            },
            options: chartDefaults
        });
    </script>
@endpush
