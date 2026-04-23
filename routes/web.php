<?php

use App\Http\Controllers\CageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Finance\ExpenseController;
use App\Http\Controllers\Finance\FinanceReportController;
use App\Http\Controllers\Finance\LivestockSaleController;
use App\Http\Controllers\Finance\ProductController;
use App\Http\Controllers\Finance\SaleController;
use App\Http\Controllers\Inventory\FeedPurchaseController;
use App\Http\Controllers\Inventory\FeedStockController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\Operations\DailyProductionController;
use App\Http\Controllers\Operations\FeedLogController;
use App\Http\Controllers\Operations\HealthLogController;
use App\Http\Controllers\Operations\MortalityLogController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SuperAdmin\SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\TenantManagementController;
use App\Http\Controllers\TenantSelectionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/tenant/select', [TenantSelectionController::class, 'index'])->name('tenant.select');
    Route::post('/tenant/switch', [TenantSelectionController::class, 'switch'])->name('tenant.switch');
    Route::get('/tenant/create', [TenantSelectionController::class, 'create'])->name('tenant.create');
    Route::post('/tenant', [TenantSelectionController::class, 'store'])->name('tenant.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'tenant', 'tenant.access'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/members', [MemberController::class, 'index'])->name('members.index');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');
    Route::post('/members', [MemberController::class, 'store'])->name('members.store');
    Route::get('/members/{user}/edit', [MemberController::class, 'edit'])->name('members.edit');
    Route::patch('/members/{user}', [MemberController::class, 'update'])->name('members.update');
    Route::delete('/members/{user}', [MemberController::class, 'destroy'])->name('members.destroy');

    Route::resource('cages', CageController::class);
    Route::post('/cages/{cage}/add-stock', [CageController::class, 'addStock'])->name('cages.add-stock');

    Route::resource('productions', DailyProductionController::class)->except(['show']);
    Route::patch('/productions/{production}/validate', [DailyProductionController::class, 'markValidated'])->name('productions.validate');
    Route::resource('feed-logs', FeedLogController::class)->except(['show']);
    Route::resource('health-logs', HealthLogController::class)->except(['show']);
    Route::resource('mortality-logs', MortalityLogController::class)->except(['show']);

    Route::resource('feed-stocks', FeedStockController::class)->except(['show']);
    Route::resource('feed-purchases', FeedPurchaseController::class)->except(['show']);

    Route::resource('products', ProductController::class)->except(['show']);
    Route::resource('sales', SaleController::class)->except(['show']);
    Route::resource('livestock-sales', LivestockSaleController::class)->except(['show']);
    Route::resource('expenses', ExpenseController::class)->except(['show']);
    Route::get('/finance/summary', FinanceReportController::class)->name('finance.summary');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/production', [ReportController::class, 'production'])->name('production');
        Route::get('/feed', [ReportController::class, 'feed'])->name('feed');
        Route::get('/mortality', [ReportController::class, 'mortality'])->name('mortality');
        Route::get('/health', [ReportController::class, 'health'])->name('health');
    });
});

Route::middleware(['auth', 'super-admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
    Route::get('/dashboard', SuperAdminDashboardController::class)->name('dashboard');

    Route::get('/tenants', [TenantManagementController::class, 'index'])->name('tenants.index');
    Route::get('/tenants/{tenant}', [TenantManagementController::class, 'show'])->name('tenants.show');
    Route::patch('/tenants/{tenant}/suspend', [TenantManagementController::class, 'suspend'])->name('tenants.suspend');
    Route::patch('/tenants/{tenant}/activate', [TenantManagementController::class, 'activate'])->name('tenants.activate');
});

require __DIR__.'/auth.php';
