<?php

use App\Http\Controllers\Administrator\AdminController;
use App\Http\Controllers\Administrator\AssetController;
use App\Http\Controllers\Administrator\AssetUpdateController;
use App\Http\Controllers\Administrator\Auth\LoginController;
use App\Http\Controllers\Administrator\DashboardController;
use App\Http\Controllers\Administrator\PackageController;
use App\Http\Controllers\Administrator\PaymentController;
use App\Http\Controllers\Administrator\ProjectController;
use App\Http\Controllers\Administrator\Reports;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\AgreementController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ClosingController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::namespace('Administrator')
    ->prefix('administrator')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('administrator.home');
        Route::get('/home-unauthorized', [DashboardController::class, 'indexUnauthorized'])->name('administrator.unauthorized');

        Route::get('/team', [AdminController::class, 'index'])->name('team.list');
        Route::get('/team/add', [AdminController::class, 'create'])->name('team.create');
        Route::post('/team/store', [AdminController::class, 'store'])->name('team.store');

        Route::namespace('Auth')->group(function () {
            Route::get('/login', [LoginController::class, 'ShowLoginForm'])->name('administrator.login');
            Route::post('/login', [LoginController::class, 'login'])->name('administrator.login.process');
            Route::post('logout', [LoginController::class, 'logout'])->name('administrator.logout');
        });

        Route::get('/migration/{booking_code}/i/{investor_id}/p/{package_id}', [App\Http\Controllers\Administrator\ClosingController::class, 'migration'])->name('admin.migration');

        Route::get('/investor/profiles', [UserController::class, 'index'])->name('admin.investor.profile');
        Route::get('/investor/profiles/{id}', [UserController::class, 'show'])->name('administrator.investor.profile.show');
        Route::get('/investor/profile/update', [UserController::class, 'update'])->name('admin.investor.profile.update');
        Route::put('/investor/bank/update', [UserController::class, 'bank_update'])->name('admin.investor.bank.update');

        Route::get('/bookings', [App\Http\Controllers\Administrator\BookingController::class, 'index'])->name('administrator.booking.index');
        Route::get('/bookings/create/{investor_id}', [App\Http\Controllers\Administrator\BookingController::class, 'create'])->name('administrator.booking.create');
        Route::post('/bookings', [App\Http\Controllers\Administrator\BookingController::class, 'store'])->name('administrator.booking.store');
        Route::get('/bookings/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'show'])->name('administrator.booking.show');
        Route::get('/bookings/edit/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'edit'])->name('administrator.booking.edit');
        Route::put('/bookings/edit/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'update'])->name('administrator.booking.update');
        Route::delete('/bookings/{booking}/payment/{payment}/delete', [App\Http\Controllers\Administrator\BookingController::class, 'payment_delete'])->name('administrator.booking.payment.delete');

        Route::get('/bookings/{id}/proof', [PaymentController::class, 'proof'])->name('administrator.booking.proof');
        Route::post('/bookings/{id}/proof', [PaymentController::class, 'proof_store'])->name('administrator.booking.proof.store');

        Route::get('/closing/{code}/edit', [App\Http\Controllers\Administrator\ClosingController::class, 'edit'])->name('administrator.closing.edit');
        Route::post('/closing/{code}/edit', [App\Http\Controllers\Administrator\ClosingController::class, 'update'])->name('administrator.closing.update');

        Route::get('/projects', [ProjectController::class, 'index'])->name('project.index');
        Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
        Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
        Route::get('/project/edit/{id}', [ProjectController::class, 'edit'])->name('project.edit');
        Route::post('/project/update', [ProjectController::class, 'update'])->name('project.update');
        Route::get('/project/delete/{id}', [ProjectController::class, 'destroy'])->name('project.delete');

        Route::get('/packages', [PackageController::class, 'index'])->name('package.index');
        Route::get('/package/create', [PackageController::class, 'create'])->name('package.create');
        Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');
        Route::get('/package/edit/{package}', [PackageController::class, 'edit'])->name('package.edit');

        Route::post('/package/update/{package}', [PackageController::class, 'update'])->name('package.update');
        Route::get('/package/delete/{package}', [PackageController::class, 'destroy'])->name('package.delete');

        Route::get('/assets', [AssetController::class, 'index'])->name('asset.index');
        Route::get('/asset/create', [AssetController::class, 'create'])->name('asset.create');
        Route::post('/asset/store', [AssetController::class, 'store'])->name('asset.store');
        Route::get('/asset/edit/{id}', [AssetController::class, 'edit'])->name('asset.edit');
        Route::post('/asset/update', [AssetController::class, 'update'])->name('asset.update');
        Route::get('/asset/delete/{id}', [AssetController::class, 'destroy'])->name('asset.delete');

        Route::get('/updates', [AssetUpdateController::class, 'index'])->name('update.index');
        Route::get('/update/create', [AssetUpdateController::class, 'create'])->name('update.create');
        Route::post('/update/store', [AssetUpdateController::class, 'store'])->name('update.store');
        Route::get('/update/edit/{id}', [AssetUpdateController::class, 'edit'])->name('update.edit');
        Route::post('/update/update', [AssetUpdateController::class, 'update'])->name('update.update');
        Route::get('/update/delete/{id}', [AssetUpdateController::class, 'destroy'])->name('update.delete');

        Route::get('/payment/pending', [App\Http\Controllers\Administrator\BookingController::class, 'payment_pending'])->name('admin.payment.index');
        Route::get('/payment/approve/{booking_id}', [App\Http\Controllers\Administrator\BookingController::class, 'payment_approve'])->name('admin.payment.approve');
        Route::get('/payment/reject/{booking_id}', [App\Http\Controllers\Administrator\BookingController::class, 'payment_reject'])->name('admin.payment.reject');
        Route::post('/payment/decision', [App\Http\Controllers\Administrator\BookingController::class, 'decision'])->name('admin.payment.decision');

        Route::get('/bookings/info/{id}', [App\Http\Controllers\Administrator\BookingController::class, 'modal_info'])->name('admin.booking.modal_info');

        Route::get('/payment/approved', [App\Http\Controllers\Administrator\BookingController::class, 'paymentProof'])->name('admin.payment.approved');
        Route::get('/payment/approved/batch', [App\Http\Controllers\Administrator\BookingController::class, 'approved_list_bybatch'])->name('admin.payment.approved_bybatch');

        Route::get('/investor/change_password/{id}', [UserController::class, 'change_password'])->name('admin.investor.change_password');
        Route::post('/investor/cp/store', [UserController::class, 'store_password'])->name('admin.investor.store_password');
        Route::get('/investor/info/{uid}', [UserController::class, 'investment_activity'])->name('admin.investor.activity');

        Route::get('investor/{status}', [UserController::class, 'userByStatus'])->name('investor.list');
        Route::get('investor/block/{userId}', [UserController::class, 'block'])->name('investor.block');
        Route::get('investor/unblock/{userId}', [UserController::class, 'unblock'])->name('investor.unblock');

        Route::get('/reports/hard-copy-requests', [Reports::class, 'agreementRequests'])->name('admin.agreement.requests');
        Route::put('/reports/agreement-status/update', [Reports::class, 'updateAgreementRequestStatus'])->name('admin.agreement.status-update');
        Route::get('/reports/hard-copy/{code}/download', [Reports::class, 'hard_copy_download'])->name('admin.agreement.download');

        Route::get('/reports/closing-investor', [Reports::class, 'closingReport'])->name('reports.closing');
        Route::get('/reports/closing-sheet', [Reports::class, 'closingSheet'])->name('reports.closing.sheet');
    });

Route::middleware(['verification'])->group(function () {
    Route::get('/', [HomeController::class, 'dashboard'])->name('index');
    Route::get('/home', [HomeController::class, 'dashboard'])->name('home');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [HomeController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/update', [HomeController::class, 'profile_update'])->name('profile.update');
    Route::get('/profile/blocked', [HomeController::class, 'profile_blocked'])->name('profile.blocked');

    Route::get('/packages', [HomeController::class, 'index'])->name('packages');

    Route::get('profile/change_password', [HomeController::class, 'change_password'])->name('change_password');
    Route::post('profile/change_password/update', [HomeController::class, 'change_password_update'])->name('change_password.update');

    Route::get('/investor/bank', [HomeController::class, 'bank_details'])->name('investor.bank.details');
    Route::post('/investor/update', [HomeController::class, 'bank_details_update'])->name('investor.bank.details.update');

    Route::get('/book/{id}/package', [HomeController::class, 'book'])->name('book');
    Route::post('/book/store', [HomeController::class, 'store'])->name('book.store');

    Route::get('/bookings', [BookingController::class, 'index'])->name('mybookings');
    Route::get('/bookings/{status}', [BookingController::class, 'myBookings'])->name('mybookings_');

    Route::get('/payment-proof/{booking_id}/submit', [BookingController::class, 'proof'])->name('paymentProof');
    Route::post('/payment-proof/store', [BookingController::class, 'proof_store'])->name('paymentProofStore');

    Route::get('/agreements', [AgreementController::class, 'index'])->name('agreement.index');
    Route::get('/agreement/{booking_id}/download', [AgreementController::class, 'download'])->name('agreement.download');

    Route::get('/agreement/hard-copy/request/{id}', [AgreementController::class, 'hard_copy_request'])->name('agreement.hard_copy');
    Route::post('/agreement/hard-copy/store', [AgreementController::class, 'hard_copy_request_store'])->name('agreement.hard_copy.store');

    Route::get('/mature-batches', [ClosingController::class, 'index'])->name('mature.index');
    Route::get('/mature-batches/request/{code}/withdrawal', [ClosingController::class, 'withdrawal_request'])->name('withdrawal.request');
    Route::post('/mature-batches/request/store', [ClosingController::class, 'withdrawal_request_store'])->name('withdrawal.request.store');
});
