<?php
if (!function_exists('getBankList')) {
    function getBankList()
    {
        static $data = null;
        if ($data == null) {
            $data = [
                // Bank BUMN & Bank Swasta Besar (Tier 1)
                'bca' => 'Bank Central Asia (BCA)',
                'bri' => 'Bank Rakyat Indonesia (BRI)',
                'bni' => 'Bank Negara Indonesia (BNI)',
                'mandiri' => 'Bank Mandiri',
                'btn' => 'Bank Tabungan Negara (BTN)',
                'cimb_niaga' => 'CIMB Niaga',
                'permata' => 'Bank Permata',
                'danamon' => 'Bank Danamon',
                'panin' => 'Bank Panin',
                'maybank' => 'Maybank Indonesia',
                'ocbc_nisp' => 'OCBC NISP',

                // Bank Swasta Lainnya dan Bank Syariah
                'syariah_indonesia' => 'Bank Syariah Indonesia (BSI)',
                'mega' => 'Bank Mega',
                'sinarmas' => 'Bank Sinarmas',
                'tabungan_pensiunan_nasional' => 'Bank BTPN',
                'jatim' => 'Bank Jatim',
                'bjb' => 'Bank BJB',
                'dki' => 'Bank DKI',
                'muamalat' => 'Bank Muamalat',
                'hana' => 'Bank KEB Hana Indonesia',
                'bukopin' => 'Bank Bukopin',
                'artha_graha' => 'Bank Artha Graha',

                // Bank Asing
                'citibank' => 'Citibank',
                'dbs' => 'Bank DBS Indonesia',
                'hsbc' => 'HSBC Indonesia',

                // Lainnya
                'lainnya' => 'Lainnya'
            ];
        }

        return $data;
    }
}

if (!function_exists('getBudgetTypeList')) {
    function getBudgetTypeList()
    {
        static $data = [
            'progress' => 'Progress',
            'table' => 'Table'
        ];

        return $data;
    }
}

if (!function_exists('getItemBudgetTypeList')) {
    function getItemBudgetTypeList()
    {
        static $data = [
            'in' => 'Pemasukan',
            'out' => 'Pengeluaran'
        ];

        return $data;
    }
}
