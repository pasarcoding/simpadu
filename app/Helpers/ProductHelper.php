<?php
if (!function_exists('getDescriptionTemplate')) {
    function getDescriptionTemplate()
    {
        static $data = null;
        if ($data == null) {
            $data = '<h3><strong>Deskripsi Produk</strong></h3>'
                . '<p>[Tulis 2-3 paragraf lengkap tentang produk Anda. Sertakan narasi yang menjelaskan fungsi, cara kerja, dan target pasar utama.]</p>'
                . '<p>Produk ini dirancang khusus untuk mengatasi masalah X yang sering dihadapi oleh [Target Pengguna]. Dengan mengintegrasikan teknologi Y, kami menjamin pengalaman pengguna yang superior dan hasil yang terukur.</p>'

                . '<br>'
                . '<h3><strong>Fitur Utama</strong></h3>'
                . '<ul>'
                . '<li><strong>[Fitur Kunci 1]:</strong> [Penjelasan singkat tentang fungsi spesifiknya.]</li>'
                . '<li><strong>[Fitur Kunci 2]:</strong> [Penjelasan singkat tentang fungsi spesifiknya.]</li>'
                . '<li><strong>[Fitur Kunci 3]:</strong> [Penjelasan singkat tentang fungsi spesifiknya.]</li>'
                . '<li><strong>[Fitur Kunci 4]:</strong> [Penjelasan singkat tentang fungsi spesifiknya.]</li>'
                . '</ul>'

                . '<br>'
                . '<h3><strong>Manfaat bagi Pengguna</strong></h3>'
                . '<ul>'
                . '<li><strong>Peningkatan Efisiensi:</strong> Memotong waktu pengerjaan tugas rutin hingga <strong>XX%</strong>.</li>'
                . '<li><strong>Hemat Biaya:</strong> Mengurangi pengeluaran bulanan Anda untuk [item tertentu].</li>'
                . '<li><strong>Kualitas Terjamin:</strong> Didukung oleh [Sertifikasi atau Garansi].</li>'
                . '</ul>'

                . '<br>'
                . '<h3><strong>Spesifikasi / Ukuran</strong></h3>'
                . '<ul>'
                . '<li><strong>Dimensi:</strong> [Panjang] cm x [Lebar] cm x [Tinggi] cm (jika fisik)</li>'
                . '<li><strong>Bahan Baku:</strong> [Material utama, contoh: Premium Cotton 30s atau Baja Tahan Karat]</li>'
                . '<li><strong>Persyaratan Sistem:</strong> [OS Minimum, browser, atau integrasi yang diperlukan.]</li>'
                . '</ul>'

                . '<br>'
                . '<h3><strong>Informasi Pemesanan &amp; Dukungan</strong></h3>'
                . '<ul>'
                . '<li><strong>Garansi:</strong> [Jenis garansi yang diberikan, contoh: 1 Tahun Kerusakan Pabrik.]</li>'
                . '<li><strong>Pengiriman:</strong> Produk siap dikirim dalam [X] hari kerja.</li>'
                . '<li><strong>Dukungan:</strong> Tersedia dukungan 24/7 melalui [Channel Komunikasi].</li>'
                . '</ul>';
        }

        return $data;
    }
}

if (!function_exists('getBuyMessageTemplate')) {
    function getBuyMessageTemplate($productName)
    {
        static $data = null;
        if ($data == null) {
            $data = 'Apakah *' . $productName . '* masih tersedia?';
        }

        return $data;
    }
}
