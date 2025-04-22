<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            Route::middleware('web')
                ->prefix('Employee_DB')
                ->group(base_path('routes/employee/employee.php'));

            Route::middleware('web')
                ->prefix('Asset')
                ->group(base_path('routes/asset/asset.php'));

            Route::middleware('web')
                ->prefix('AssetAssign')
                ->group(base_path('routes/asset_assign/asset_assigns.php'));

            Route::middleware('web')
                ->prefix('AssetScanning')
                ->group(base_path('routes/asset_scanned/asset_scanned.php'));

            Route::middleware('web')
                ->prefix('PrintBarcode')
                ->group(base_path('routes/printing_code/print_code.php'));

            Route::middleware('web')
                ->prefix('AssetCategory')
                ->group(base_path('routes/asset_category/asset_category.php'));

            Route::middleware('web')
                ->prefix('AssetStatus')
                ->group(base_path('routes/asset_status/asset_status.php'));

            Route::middleware('web')
                ->prefix('SupplierMain')
                ->group(base_path('routes/supplier_main/supplier_main.php'));

            Route::middleware('web')
                ->prefix('Approvers')
                ->group(base_path('routes/approval_matrix/approval_matrix.php'));

            Route::middleware('web')
                ->prefix('Gatepass')
                ->group(base_path('routes/gatepass/gatepass.php'));

            Route::middleware('web')
                ->prefix('GatepassScan')
                ->group(base_path('routes/gatepass_scan/gatepass_scan.php'));

            Route::middleware('web')
                ->prefix('AssetTransfer')
                ->group(base_path('routes/asset_transfer/asset_transfer.php'));

            Route::middleware('web')
                ->prefix('AssetReturn')
                ->group(base_path('routes/asset_return/asset_return.php'));

            Route::middleware('web')
                ->prefix('BorrowedAsset')
                ->group(base_path('routes/borrowed_asset/borrowed_asset.php'));

            Route::middleware('web')
                ->prefix('AssetDisposal')
                ->group(base_path('routes/asset_disposal/asset_disposal.php'));

            Route::middleware('web')
                ->prefix('AssetCount')
                ->group(base_path('routes/asset_count/asset_count.php'));

            Route::middleware('web')
                ->prefix('employee')
                ->group(base_path('routes/employee_login/employee_login.php'));
                
                
        });
    }
}
