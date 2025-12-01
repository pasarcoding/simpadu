<?php
if (!function_exists('getGenderList')) {
    function getGenderList()
    {
        static $data = [
            "L" => "Laki-Laki",
            "P" => "Perempuan",
        ];

        return $data;
    }
}

if (!function_exists('getReligionList')) {
    function getReligionList()
    {
        static $data = [
            "islam" => "Islam",
            "kristen_protestan" => "Kristen Protestan",
            "kristen_katolik" => "Kristen Katolik",
            "hindu" => "Hindu",
            "budha" => "Budha",
            "konghucu" => "Konghucu",
        ];

        return $data;
    }
}

if (!function_exists('getJobList')) {
    function getJobList()
    {
        static $data = null;

        if ($data == null) {
            $data = [
                "belum_tidak_bekerja" => "Belum/Tidak Bekerja",
                "mengurus_rumah_tangga" => "Mengurus Rumah Tangga",
                "pelajar_mahasiswa" => "Pelajar Mahasiswa",
                "pensiunan" => "Pensiunan",
                "pegawai_negeri_sipil_pns" => "Pegawai Negeri Sipil (Pns)",
                "tni" => "Tni",
                "polri" => "Polri",
                "petani_pekebun" => "Petani/Pekebun",
                "peternak" => "Peternak",
                "nelayan_perikanan" => "Nelayan/Perikanan",
                "karyawan_swasta" => "Karyawan Swasta",
                "wiraswasta" => "Wiraswasta",
                "lainnya" => "Lainnya",
            ];
        }

        return $data;
    }
}

if (!function_exists('getEducationList')) {
    function getEducationList()
    {
        static $data = null;

        if ($data == null) {
            $data = [
                "tidak_belum_sekolah" => "Tidak/Belum Sekolah",
                "belum_tamat_sd_sederajat" => "Belum Tamat Sd/Sederajat",
                "sd_sederajat" => "Sd/Sederajat",
                "sltp_sederajat" => "Sltp/Sederajat",
                "slta_sederajat" => "Slta/Sederajat",
                "diploma_i" => "Diploma I",
                "diploma_ii" => "Diploma Ii",
                "diploma_iii" => "Diploma Iii",
                "diploma_iv_s1" => "Diploma Iv/S1",
                "s2" => "S2",
                "s3" => "S3",
            ];
        }

        return $data;
    }
}

if (!function_exists('getMaritalStatusList')) {
    function getMaritalStatusList()
    {
        static $data = [
            "belum_nikah" => "Belum Nikah",
            "nikah" => "Nikah",
            "cerai_hidup" => "Cerai Hidup",
            "cerai_mati" => "Cerai Mati",
        ];

        return $data;
    }
}

if (!function_exists('getFamilyRelationshipList')) {
    function getFamilyRelationshipList()
    {
        static $data = [
            "suami_kepala_keluarga" => "Suami/Kepala Keluarga",
            "istri" => "Istri",
            "anak" => "Anak",
            "mertua" => "Mertua",
            "menantu" => "Menantu",
            "cucu" => "Cucu",
            "orang_tua" => "Orang Tua",
            "lainnya" => "Lainnya",
        ];

        return $data;
    }
}

if (!function_exists('getDeathStatusList')) {
    function getDeathStatusList()
    {
        static $data = [
            "hidup" => "Hidup",
            "meninggal" => "Meninggal",
        ];

        return $data;
    }
}

if (!function_exists('getCitizenshipList')) {
    function getCitizenshipList()
    {
        static $data = [
            "wni" => "Warga Negara Indonesia",
            "wna" => "Warga Negara Asing",
        ];

        return $data;
    }
}
