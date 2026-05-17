<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\EventPageController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\TicketPageController;
use App\Http\Controllers\Web\OrderPageController;
use App\Http\Controllers\Web\OrganizerEventController;
use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\CheckinPageController;
use App\Http\Controllers\Web\UserPageController;
use App\Http\Controllers\Web\ProfileController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/events', [EventPageController::class, 'index'])
    ->name('events.index');

Route::get('/events/{slug}', [EventPageController::class, 'show'])
    ->name('events.show');

Route::get('/my-ticket/{ticketCode}', [TicketPageController::class, 'show'])
    ->name('ticket.show');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [LoginController::class, 'showRegister'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

Route::get('/admin/analytics', [DashboardController::class, 'adminAnalytics'])
    ->name('admin.analytics');

Route::get('/organizer/analytics', [DashboardController::class, 'organizerAnalytics'])
    ->name('organizer.analytics');

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD
    |--------------------------------------------------------------------------
    */

    Route::get('/organizer/dashboard', [DashboardController::class, 'organizer'])
        ->name('organizer.dashboard');

    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
        ->name('admin.dashboard');

    /*
    |--------------------------------------------------------------------------
    | USER TICKETS
    |--------------------------------------------------------------------------
    */

    Route::get('/my-tickets', [TicketPageController::class, 'index'])
        ->name('tickets.index');

    Route::get('/my-tickets/{ticketCode}', [TicketPageController::class, 'show'])
        ->name('tickets.show');

    Route::get('/upcoming',      [UserPageController::class, 'upcoming'])->name('user.upcoming');
    Route::get('/transactions',  [UserPageController::class, 'transactions'])->name('user.transactions');
    Route::get('/qr-ticket',     [UserPageController::class, 'qrTicket'])->name('user.qr-ticket');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/home', [UserPageController::class, 'home'])->name('user.home');

    /*
    |--------------------------------------------------------------------------
    | BUY TICKET
    |--------------------------------------------------------------------------
    */

    Route::post('/buy-ticket', [OrderPageController::class, 'store'])
        ->name('buy.ticket');

    /*
    |--------------------------------------------------------------------------
    | ORGANIZER
    |--------------------------------------------------------------------------
    */

    Route::prefix('organizer')->group(function () {

        Route::get('/events', [OrganizerEventController::class, 'index'])
            ->name('organizer.events.index');

        Route::get('/events/create', [OrganizerEventController::class, 'create'])
            ->name('organizer.events.create');

        Route::post('/events', [OrganizerEventController::class, 'store'])
            ->name('organizer.events.store');

        Route::get('/events/{id}/edit', [OrganizerEventController::class, 'edit'])
            ->name('organizer.events.edit');

        Route::put('/events/{id}', [OrganizerEventController::class, 'update'])
            ->name('organizer.events.update');

        Route::get('/checkin-scanner', [CheckinPageController::class, 'index'])
            ->name('organizer.checkin.scanner');

        Route::post('/checkin', [CheckinPageController::class, 'checkin'])
            ->name('organizer.checkin');
    });
});
