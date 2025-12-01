<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupApplication extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Memulai Proses Penyiapan Aplikasi ===');

        $this->comment('Membuat symlink storage...');
        try {
            Artisan::call('storage:link', [], $this->output);
            $this->info('✅ Symlink berhasil dibuat.');
        } catch (\Exception $e) {
            $this->error('❌ Gagal membuat symlink: ' . $e->getMessage());
        }

        $this->comment('Menjalankan migrasi database...');
        $this->call('migrate', [
             '--force' => true
        ]);
        $this->info('✅ Migrasi database selesai.');

        $this->comment('Menjalankan database seeder...');
        $this->call('db:seed', [
             '--force' => true
        ]);
        $this->info('✅ Database seeder selesai.');

        $this->info('=== ✅ Proses Penyiapan Selesai! Aplikasi siap digunakan ===');

        return 0;
    }
}
