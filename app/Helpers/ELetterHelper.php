<?php
if (!function_exists('getTemplateStatusList')) {
    function getTemplateStatusList()
    {
        static $data = [
            "active" => "Aktif",
            "nonactive" => "Tidak Aktif",
        ];

        return $data;
    }
}

if (!function_exists('getTemplateVaribalePattern')) {
    function getTemplateVaribalePattern()
    {
        static $data = null;

        if ($data == null) {
            $data = '/^(' . config('e_letter.allowed_inputType') . ')::([a-zA-Z0-9_]+)\((.*?)\)$/';
        }

        return $data;
    }
}

if (!function_exists('getTemplateVaribaleNoLabelPattern')) {
    function getTemplateVaribaleNoLabelPattern()
    {
        static $data = null;

        if ($data == null) {
            $data =  '/^(' . config('e_letter.allowed_inputType') . ')::([a-zA-Z0-9_]+)$/';
        }

        return $data;
    }
}

if (!function_exists('getSubmissionStatusList')) {
    function getSubmissionStatusList()
    {
        static $data = null;

        if ($data == null) {
            $data = [
                'submitted' => 'Diajukan',
                'verification' => 'Verifikasi',
                'signed' => 'Ditandatangani',
                'completed' => 'Selesai',
                'rejected' => 'Ditolak',
            ];
        }

        return $data;
    }
}

if (!function_exists('getResidentVaribleTemplateList')) {
    function getResidentVaribleTemplateList()
    {
        static $data = null;

        if ($data == null) {
            $data = [
                'national_id' => 'nik_penduduk',
                'full_name' => 'nama_penduduk',
                'gender' => 'jenis_kelamin_penduduk',
                'birth_place' => 'tempat_lahir_penduduk',
                'birth_date' => 'tanggal_lahir_penduduk',
                'religion' => 'agama_penduduk',
                'citizenship' => 'kewarganegaraan_penduduk',
                'death_status' => 'status_kematian_penduduk',
                'transfer_date' => 'tanggal_pindah_penduduk',
                'job' => 'pekerjaan_penduduk',
                'last_education' => 'pendidikan_penduduk',
                'marital_status' => 'status_perkawinan_penduduk',
                'family_relationship' => 'hubungan_keluarga_penduduk',
                'family_card_number' => 'kk_penduduk',
                'address' => 'alamat_penduduk',
                'rt' => 'rt_penduduk',
                'rw' => 'rw_penduduk',
                'hamlet_village' => 'dusun_penduduk',
            ];
        }

        return $data;
    }
}

if (!function_exists('getLetterNumberVaribleTemplate')) {
    function getLetterNumberVaribleTemplate()
    {
        return 'nomor_surat';
    }
}
