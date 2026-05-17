@extends('layouts.dashboard')

@section('content')

<div class="space-y-10">

    <!-- HEADER -->
    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-5xl font-black">
                Admin Dashboard
            </h1>

            <p class="text-slate-400 mt-3">
                Monitor seluruh aktivitas platform Vokatif.
            </p>
        </div>

        <div class="glass px-6 py-4 rounded-2xl">
            <p class="text-slate-400 text-sm">
                System Status
            </p>

            <h2 class="text-emerald-400 font-bold text-xl">
                Operational
            </h2>
        </div>

    </div>

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        <div class="glass rounded-3xl p-6">
            <p class="text-slate-400">Total Users</p>
            <h2 class="text-5xl font-black mt-4">
                {{ $totalUsers }}
            </h2>
        </div>

        <div class="glass rounded-3xl p-6">
            <p class="text-slate-400">Total Events</p>
            <h2 class="text-5xl font-black mt-4">
                {{ $totalEvents }}
            </h2>
        </div>

        <div class="glass rounded-3xl p-6">
            <p class="text-slate-400">Tickets Sold</p>
            <h2 class="text-5xl font-black mt-4">
                {{ $totalTickets }}
            </h2>
        </div>

        <div class="gradient-card rounded-3xl p-6">
            <p class="text-white/70">Revenue</p>
            <h2 class="text-4xl font-black mt-4">
                Rp{{ number_format($totalRevenue, 0, ',', '.') }}
            </h2>
        </div>

    </div>

    <!-- CHART + ROLE -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- CHART -->
        <div class="glass rounded-3xl p-6 xl:col-span-2">

            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-bold">
                        Revenue Analytics
                    </h2>

                    <p class="text-slate-400">
                        Monthly transaction overview
                    </p>
                </div>
            </div>

            <canvas id="revenueChart" height="120"></canvas>

        </div>

        <!-- ROLE STATS -->
        <div class="glass rounded-3xl p-6">

            <h2 class="text-2xl font-bold mb-6">
                User Roles
            </h2>

            <div class="space-y-4">

                @foreach($roleStats as $role => $count)

                    <div class="glass rounded-2xl p-4 flex items-center justify-between">

                        <div>
                            <p class="capitalize text-lg font-bold">
                                {{ $role }}
                            </p>
                        </div>

                        <div class="text-cyan-400 text-2xl font-black">
                            {{ $count }}
                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="glass rounded-3xl p-6">

        <div class="flex items-center justify-between mb-6">

            <div>
                <h2 class="text-2xl font-bold">
                    Latest Orders
                </h2>

                <p class="text-slate-400">
                    Recent ticket transactions
                </p>
            </div>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>
                    <tr class="text-left border-b border-white/10">

                        <th class="pb-4">User</th>
                        <th class="pb-4">Event</th>
                        <th class="pb-4">Payment</th>
                        <th class="pb-4">Status</th>
                        <th class="pb-4">Date</th>

                    </tr>
                </thead>

                <tbody>

                    @foreach($latestOrders as $order)

                        <tr class="border-b border-white/5">

                            <td class="py-5">
                                {{ $order->user->name }}
                            </td>

                            <td class="py-5">
                                {{ $order->event->title }}
                            </td>

                            <td class="py-5 text-cyan-400 font-bold">
                                Rp{{ number_format($order->total_amount, 0, ',', '.') }}
                            </td>

                            <td class="py-5">

                                <span class="
                                    px-4 py-2 rounded-full text-sm font-bold

                                    {{ $order->payment_status === 'paid'
                                        ? 'bg-emerald-500/20 text-emerald-400'
                                        : 'bg-yellow-500/20 text-yellow-400'
                                    }}
                                ">
                                    {{ $order->payment_status }}
                                </span>

                            </td>

                            <td class="py-5 text-slate-400">
                                {{ $order->created_at->format('d M Y') }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>

const ctx = document.getElementById('revenueChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun'
        ],
        datasets: [{
            label: 'Revenue',
            data: [
                1200000,
                1900000,
                3000000,
                2500000,
                4200000,
                5100000
            ],
            borderColor: '#06b6d4',
            tension: 0.4
        }]
    }
});

</script>

@endsection