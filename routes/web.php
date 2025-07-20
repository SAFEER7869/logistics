<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SalarySlipController;
use App\Http\Controllers\AdjustmentTypesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\PayrollPeriodController;
use Illuminate\Support\Facades\Route;
     use App\Http\Controllers\PayPalController;

  Route::get('/payment/success', [AdminDashboardController::class, 'success'])->name('client.success');
    Route::get('/', function () {
        return view('welcome');
    });

    Route::middleware(['auth', 'useractive'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::resource('employees', EmployeeController::class);
        Route::resource('admins', UserController::class);
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::post('users/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');


        //pclups
         Route::get('pickups', [PickupController::class, 'index'])->name('pickups.index');
         
                  Route::get('pickups/edit/{pickup}', [PickupController::class, 'edit'])->name('pickups.edit');
                                    Route::delete('pickups/{pickup}', [PickupController::class, 'destroy'])->name('pickups.destroy');
                                                            Route::post('pickups/{pickup}', [PickupController::class, 'update'])->name('pickups.update');
                  


    });

    //api
      Route::get('pickups/create', [PickupController::class, 'create'])->name('pickups.create');
    Route::post('/pickups', [PickupController::class, 'store'])->name('pickups.store');

    //track
          Route::get('pickups/track', [PickupController::class, 'trackindex'])->name('pickups.trackindex');
           Route::post('pickups/trackcheck', [PickupController::class, 'trackcheck'])->name('pickups.trackcheck');

       //email
        Route::get('sendemail/{pickup}', [PickupController::class, 'sendemail'])->name('pickups.sendemail');

   

        Route::get('/pay-advance/{pickupId}', [PayPalController::class, 'createPayment'])->name('paypal.pay');
        Route::get('/paypal/success/{pickupId}', [PayPalController::class, 'handleSuccess'])->name('paypal.success');
        Route::get('/paypal/cancel/{pickupId}', [PayPalController::class, 'handleCancel'])->name('paypal.cancel');
require __DIR__.'/auth.php';


// In routes/web.php
Route::get('/', function () {
    return view('welcome');  // Home page or dashboard view
})->name('home');
