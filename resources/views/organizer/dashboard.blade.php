@extends('layouts.dashboard')

@section('content')
    <div class="space-y-10">

        <!-- HEADER -->
        <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-6 mb-10">

            <!-- KIRI -->
            <div>
                <h1 class="text-5xl font-black">Organizer Dashboard</h1>
                <p class="text-slate-400 mt-3">Kelola event, tiket, dan check-in peserta.</p>
            </div>

            <!-- KANAN -->
            <div class="flex items-center gap-4 flex-wrap justify-end">

                <a href="/organizer/events"
                    class="px-6 py-4 rounded-3xl bg-cyan-500/20 text-cyan-300 font-bold hover:bg-cyan-500/30 transition">
                    Manage Events
                </a>

                <a href="/organizer/events/create"
                    class="px-6 py-4 rounded-3xl bg-violet-600 text-white font-bold hover:bg-violet-500 transition">
                    Add New Event
                </a>

                <a href="/organizer/checkin-scanner"
                    class="px-6 py-4 rounded-3xl bg-violet-600 hover:bg-violet-500 font-bold transition">
                    Open QR Scanner
                </a>

                <div class="gradient-card rounded-3xl px-8 py-5">
                    <p class="text-white/70">Estimated Revenue</p>
                    <h2 class="text-4xl font-black mt-2">
                        Rp{{ number_format($totalRevenue, 0, ',', '.') }}
                    </h2>
                </div>

            </div>

        </div>

        <!-- STATS -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <div class="glass rounded-3xl p-6">

                <p class="text-slate-400">
                    Total Events
                </p>

                <h2 class="text-5xl font-black mt-4">
                    {{ $totalEvents }}
                </h2>

            </div>

            <div class="glass rounded-3xl p-6">

                <p class="text-slate-400">
                    Published Events
                </p>

                <h2 class="text-5xl font-black mt-4">
                    {{ $publishedEvents }}
                </h2>

            </div>

            <div class="glass rounded-3xl p-6">

                <p class="text-slate-400">
                    Tickets Sold
                </p>

                <h2 class="text-5xl font-black mt-4">
                    {{ $totalTicketsSold }}
                </h2>

            </div>

            <div class="glass rounded-3xl p-6">

                <p class="text-slate-400">
                    Total Check-ins
                </p>

                <h2 class="text-5xl font-black mt-4">
                    {{ $totalCheckins }}
                </h2>

            </div>

        </div>

        <!-- ANALYTICS -->
        <div class="grid lg:grid-cols-2 gap-8">

            <!-- REVENUE -->
            <div class="glass rounded-[32px] p-8">

                <div class="mb-8">

                    <h2 class="text-3xl font-black">
                        Revenue Analytics
                    </h2>

                    <p class="text-slate-400 mt-2">
                        Monthly revenue realtime
                    </p>

                </div>

                <canvas id="revenueChart" height="120"></canvas>

            </div>

            <!-- TICKETS -->
            <div class="glass rounded-[32px] p-8">

                <div class="mb-8">

                    <h2 class="text-3xl font-black">
                        Ticket Analytics
                    </h2>

                    <p class="text-slate-400 mt-2">
                        Ticket sold per month
                    </p>

                </div>

                <canvas id="ticketChart" height="120"></canvas>

            </div>

        </div>

        <!-- EVENT CARDS -->
        <div>

            <div class="flex items-center justify-between mb-6">

                <div>

                    <h2 class="text-3xl font-black">
                        Managed Events
                    </h2>

                    <p class="text-slate-400">
                        Event yang sedang dikelola organizer.
                    </p>

                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">

                @foreach ($events as $event)
                    <div class="glass rounded-3xl overflow-hidden">

                        <div class="h-48 gradient-card"></div>

                        <div class="p-6">

                            <div class="flex items-center justify-between mb-4">

                                <span class="px-4 py-2 rounded-full bg-fuchsia-500/20 text-fuchsia-400 text-sm font-bold">
                                    {{ $event->category->name }}
                                </span>

                                <span class="text-slate-400 text-sm">
                                    {{ $event->ticketTypes->count() }} ticket type
                                </span>

                            </div>

                            <h2 class="text-2xl font-black mb-3">
                                {{ $event->title }}
                            </h2>

                            <p class="text-slate-400 line-clamp-2">
                                {{ $event->description }}
                            </p>

                            <div class="mt-6 flex items-center justify-between">

                                <div>

                                    <p class="text-slate-500 text-sm">
                                        Status
                                    </p>

                                    <h3
                                        class="
                                    font-bold

                                    {{ $event->status === 'published' ? 'text-emerald-400' : 'text-yellow-400' }}
                                ">
                                        {{ ucfirst($event->status) }}
                                    </h3>

                                </div>

                                <a href="/organizer/events/{{ $event->id }}/edit"
                                    class="px-5 py-3 rounded-2xl bg-cyan-500/20 text-cyan-400 font-bold hover:bg-cyan-500/30 transition">

                                    Manage

                                </a>

                            </div>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

        <!-- RECENT ORDERS -->
        <div class="glass rounded-3xl p-6">

            <div class="mb-6">

                <h2 class="text-3xl font-black">
                    Latest Orders
                </h2>

                <p class="text-slate-400">
                    Transaksi terbaru event organizer.
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="border-b border-white/10 text-left">

                            <th class="pb-4">User</th>
                            <th class="pb-4">Event</th>
                            <th class="pb-4">Payment</th>
                            <th class="pb-4">Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($latestOrders as $order)
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

                                    <span
                                        class="
                                    px-4 py-2 rounded-full text-sm font-bold

                                    {{ $order->payment_status === 'paid'
                                        ? 'bg-emerald-500/20 text-emerald-400'
                                        : 'bg-yellow-500/20 text-yellow-400' }}
                                ">
                                        {{ $order->payment_status }}
                                    </span>

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        <!-- CHECKIN -->
        <div class="glass rounded-3xl p-6">

            <div class="mb-6">

                <h2 class="text-3xl font-black">
                    Latest Check-ins
                </h2>

                <p class="text-slate-400">
                    Aktivitas scan QR terbaru.
                </p>

            </div>

            <div class="space-y-4">

                @foreach ($latestCheckins as $checkin)
                    <div class="glass rounded-2xl p-5 flex items-center justify-between">

                        <div>

                            <h2 class="text-xl font-bold">
                                {{ $checkin->ticket->user->name }}
                            </h2>

                            <p class="text-slate-400">
                                {{ $checkin->event->title }}
                            </p>

                        </div>

                        <div class="text-right">

                            <p class="text-emerald-400 font-bold">
                                {{ ucfirst($checkin->status) }}
                            </p>

                            <p class="text-slate-500 text-sm">
                                {{ $checkin->created_at->format('d M Y H:i') }}
                            </p>

                        </div>

                    </div>
                @endforeach

            </div>

        </div>

    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /*
            |--------------------------------------------------------------------------
            | DATA
            |--------------------------------------------------------------------------
            */

            const months = JSON.parse(
                '@json($months)'
            );

            const monthlyRevenue = JSON.parse(
                '@json($monthlyRevenue)'
            );

            const monthlyTickets = JSON.parse(
                '@json($monthlyTickets)'
            );


            /*
            |--------------------------------------------------------------------------
            | REVENUE CHART
            |--------------------------------------------------------------------------
            */

            const revenueCanvas = document.getElementById('revenueChart');

            if (revenueCanvas) {
                new Chart(revenueCanvas, {

                    type: 'line',

                    data: {

                        labels: months,

                        datasets: [{

                            label: 'Revenue',

                            data: monthlyRevenue,

                            borderColor: '#06b6d4',

                            backgroundColor: 'rgba(6,182,212,0.2)',

                            fill: true,

                            tension: 0.4

                        }]

                    },

                    options: {

                        responsive: true,

                        plugins: {

                            legend: {

                                labels: {
                                    color: '#ffffff'
                                }

                            }

                        },

                        scales: {

                            x: {

                                ticks: {
                                    color: '#94a3b8'
                                }

                            },

                            y: {

                                ticks: {
                                    color: '#94a3b8'
                                }

                            }

                        }

                    }

                });
            }


            /*
            |--------------------------------------------------------------------------
            | TICKET CHART
            |--------------------------------------------------------------------------
            */

            const ticketCanvas = document.getElementById('ticketChart');

            if (ticketCanvas) {
                new Chart(ticketCanvas, {

                    type: 'bar',

                    data: {

                        labels: months,

                        datasets: [{

                            label: 'Tickets Sold',

                            data: monthlyTickets,

                            backgroundColor: '#8b5cf6',

                            borderRadius: 12

                        }]

                    },

                    options: {

                        responsive: true,

                        plugins: {

                            legend: {

                                labels: {
                                    color: '#ffffff'
                                }

                            }

                        },

                        scales: {

                            x: {

                                ticks: {
                                    color: '#94a3b8'
                                }

                            },

                            y: {

                                ticks: {
                                    color: '#94a3b8'
                                }

                            }

                        }

                    }

                });
            }

        });
    </script>
@endpush
