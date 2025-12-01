<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Setting\App\Models\Setting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateOrCreate(
            [
                'key' => 'appearance'
            ],
            [
                'value' => [
                    'color_primary' => '#15aa3d',
                    'color_secondary' => '#ec8544',
                    'color_accent' => '#219ad0',
                    'background_banner' => null,
                ],
            ]
        );
        Setting::updateOrCreate(
            [
                'key' => 'e_letter'
            ],
            [
                'value' => [
                    'success' => "Yth. Bapak/Ibu *\${nama_penduduk}*,\r\nNIK: *\${nik_penduduk}*,\r\n\r\nKami informasikan bahwa permohonan surat *\${jenis_surat}* Anda telah *SELESAI* diproses.\r\n\r\nNomor Surat: *\${nomor_surat}*\r\n\r\nSurat Anda dapat diambil langsung di Kantor Desa/Kelurahan.\r\n\r\nMohon tunjukkan kartu identitas Anda saat pengambilan. Terima kasih.\r\n\r\nHormat kami,\r\n*\${aplikasi}*",
                    'reject' => "Yth. Bapak/Ibu *\${nama_penduduk}*,\r\nNIK: *\${nik_penduduk}*,\r\n\r\nKami informasikan bahwa permohonan surat *\${jenis_surat}* Anda *DITOLAK/DIBATALKAN* karena:\r\n\r\n*Alasan Penolakan:*\r\n[Sebutkan alasan yang jelas, cth: Dokumen KK yang dilampirkan kadaluarsa / Persyaratan belum lengkap].\r\n\r\nSilakan perbaiki persyaratan dan ajukan kembali permohonan Anda.\r\n\r\nHormat kami,\r\n*\${aplikasi}*",
                ],
            ]
        );
        $this->command->info("✅ Setting berhasil dibuat.");
    }
}
