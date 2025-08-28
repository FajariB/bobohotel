<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\HotelRoomController;
use App\Http\Controllers\HotelBookingController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('can:manage cities')->group(function () {
        Route::resource('cities', CityController::class);
    });

    Route::middleware('can:manage countries')->group(function () {
        Route::resource('countries', CountryController::class);
    });

    Route::middleware('can:manage hotels')->group(function () {
        Route::resource('hotels', HotelController::class);
    });

    Route::middleware('can:manage hotels')->group(function () {
        Route::get('/add/room/{hotel:slug}', [HotelRoomController::class, 'create']) //get form untuk menampilkan data dari database
        ->name('hotel_rooms.create');
        Route::post('/add/room/{hotel:slug}/store', [HotelRoomController::class, 'store']) //post untuk mengirim data ke database
        ->name('hotel_rooms.store');
        Route::get('/hotel/{hotel:slug}/room/{hotel_room}', [HotelRoomController::class, 'edit'])
        ->name('hotel_rooms.edit');
        Route::put('/room/{hotel_room}/update', [HotelRoomController::class, 'update']) //put untuk mengupdate data di database
        ->name('hotel_rooms.update');
        Route::delete('/hotel/{hotel:slug}/delete/{hotel_room}', [HotelRoomController::class, 'destroy']) //delete untuk menghapus data di database
        ->name('hotel_rooms.destroy');  
    });

    Route::middleware('can:manage hotel bookings')->group(function () {
        Route::resource('hotel_bookings', HotelBookingController::class); //untuk menampilkan semua data booking 
    });
});

// Route::middleware(['auth', 'role:super admin|admin'])->group(function () {
//     Route::resource('countries', \App\Http\Controllers\CountryController::class);
//     Route::resource('cities', \App\Http\Controllers\CityController::class);
//     Route::resource('hotels', \App\Http\Controllers\HotelController::class);
//     Route::resource('rooms', \App\Http\Controllers\HotelRoomController::class);
//     Route::resource('bookings', \App\Http\Controllers\HotelBookingController::class);
//     Route::get('reports', [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
//     Route::get('reports/generate', [\App\Http\Controllers\ReportController::class, 'generate'])->name('reports.generate');
// });

require __DIR__.'/auth.php';
