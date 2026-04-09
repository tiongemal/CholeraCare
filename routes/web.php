<?php

use App\Models\supplies;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\DataSyncController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplyController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;


    // User related routes

    ///register related user routes
    Route::group(['middleware' => 'admin'], function () {
        Route::get('/locations', [LocationController::class, 'create'])->name('locations.create');
        Route::post('/locations/create', [LocationController::class, 'store'])->name('locations.store');
        Route::get('/register', [UserController::class, 'RegisterPage'])->name('register');
        Route::post('/registerpost', [UserController::class, 'register'])->name('register.post');


    });




    Route::group(['middleware' => 'MustBeLoggedIN'], function () {

        Route::get('/homepage', [HomeController::class, 'index']);

         ///logged in related user routes
            Route::view('/home','homepage')->name('home');

            Route::view('/dashboard','dashboard');

            Route::get('/', [UserController::class, 'loggedin']);

            Route::get('/profile/{fullname}', [UserController::class, 'profile'])->name('profile');

            Route::get("/report", [ReportController::class, 'reportTable'])->name('reports')->middleware('report');

            Route::post('/reportsubmit', [ReportController::class, 'store']);
            Route::get('/reportform', [ReportController::class, 'view'])->name('report');

            Route::get('/admindash', [UserController::class, 'totalUsers']);


            // Dashboard routes

            route::get('/admin_dash', [UserController::class, 'profile'])->name('admin-dash');
            route::get('/hqdash', [UserController::class, 'profile'])->name('HQ-dash');



            // supplies routes
            Route::get('/supplies/create', [SupplyController::class, 'create'])->name('supplies.create');
            Route::post('/supplies', [SupplyController::class, 'store'])->name('supplies.store');
            Route::get('/suppliesShow', [SupplyController::class, 'index'])->name('supplies.index');

            Route::get('/supplies/{id}/edit', [SupplyController::class, 'edit'])->name('supplies.edit');
            Route::delete('/supplies/{id}', [SupplyController::class, 'destroy'])->name('supplies.destroy');


            Route::post('/restock-requests', [SupplyController::class, 'RestockRequest'])->name('restock.requests.store');

            Route::put('/supplies/{id}', [SupplyController::class, 'update'])->name('supplies.update');


            Route::get('/restocknotifications', [SupplyController::class, 'RestockRequestNotifications'])->name('restock.requests.index')->middleware('auth');


            Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');


             ///logout related user routes
            Route::post('/logout', [UserController::class, 'logout'])->name('logout');


            Route::get('/reports', [ReportController::class, 'reportTable'])->name('reports.index');



            Route::get('/data-sync', [DataSyncController::class, 'sync']);
            Route::get('/sync-logs', [DataSyncController::class, 'index'])->name('sync.logs');
    });

    ///login related user routes
    Route::get('/loginpage',function() {
        return view('auth.login');})->name('loginpage');

    Route::post('/login', [UserController::class, 'login']);


// chart routes
Route::get('/chart', [ChartController::class, 'barChart'])->name('analytics');
Route::get('/charts', [ChartController::class, 'charts'])->name('charts');


Route::get('/session', [UserController::class, 'showSessionData'] );
Route::get('/location', [LocationController::class, 'showlocation']);

Route::get('/reports', [ReportController::class, 'reportTable'])->name('reportTable');


// Display the admin dashboard with users
Route::get('/dashboard/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::get('/dashboard/admin/users', [AdminController::class, 'index'])->name('admin.dashboard');

// Route to toggle user status
Route::post('/users/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.users.toggleStatus');






Route::get('/admin/users/search', [UserController::class, 'search'])->name('admin.users.search');
Route::post('/admin/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggleStatus');
