<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DestroyApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:destroy';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Memulai Proses Reset Aplikasi ===');

        $this->comment('Menghapus isi folder storage/app/public...');
        $storagePath = storage_path('app/public');

        try {
            if (File::isDirectory($storagePath)) {
                File::cleanDirectory($storagePath);
                $this->info('✅ Isi Storage berhasil dihapus.');
            } else {
                $this->warn('❌ Folder storage/app/public tidak ditemukan.');
            }
        } catch (\Exception $e) {
            $this->error('❌ Gagal menghapus Storage: ' . $e->getMessage());
        }

        $this->comment('Menghapus symlink public/storage...');
        $symlinkPath = public_path('storage');

        try {
            if (File::exists($symlinkPath)) {
                if (is_link($symlinkPath)) {
                    unlink($symlinkPath);
                    $this->info('✅ Symlink berhasil dihapus.');
                } else {
                    File::deleteDirectory($symlinkPath);
                    $this->info('✅ Direktori public/storage berhasil dihapus.');
                }
            } else {
                $this->warn('❌ Symlink public/storage tidak ditemukan.');
            }
        } catch (\Exception $e) {
            $this->error('❌ Gagal menghapus Symlink/Direktori: ' . $e->getMessage());
        }

        $this->comment('Menghapus isi database...');
        $this->call('migrate:reset', [
            '--force' => true
        ]);
        $this->info('✅ Database berhasil di-reset.');

        $this->info('=== Proses Reset Aplikasi Selesai. Database kosong, Storage bersih ===');

        return 0;
    }
}
