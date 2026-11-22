<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Konfigurasi Kolom Pokja 3: Program Pangan & Sandang
    |--------------------------------------------------------------------------
    | Sesuai format resmi PKK Kabupaten Nganjuk:
    | - Pangan: Kader Pangan, Makanan Pokok (Beras, Non Beras),
    |   Pemanfaatan Pekarangan / Hatinya PKK (7 jenis tanaman/ternak/ikan),
    |   dan Industri Rumah Tangga (Pangan).
    | - Sandang: Kader Sandang, Industri Rumah Tangga (Sandang, Jasa).
    |
    | Penempatan kolom seperti 'industri_pangan' dan 'jasa' dapat disesuaikan
    | secara fleksibel di file konfigurasi ini.
    */

    'pangan' => [
        'name' => 'Program Pangan',
        'table' => 'laporan_pangan',
        'kader_column' => 'kader_pangan',
        'irt_pangan_column' => 'industri_pangan',
        'columns' => [
            'kader_pangan'    => 'Kader Pangan',
            'beras'           => 'Beras',
            'non_beras'       => 'Non Beras',
            'peternakan'      => 'Peternakan',
            'perikanan'       => 'Perikanan',
            'warung_hidup'    => 'Warung Hidup',
            'lumbung_hidup'   => 'Lumbung Hidup',
            'toga'            => 'TOGA',
            'tanaman_keras'   => 'Tanaman Keras',
            'tanaman_lainnya' => 'Tanaman Lainnya',
            'industri_pangan' => 'IRT Pangan',
        ],
        'groups' => [
            'kader' => ['kader_pangan'],
            'makanan_pokok' => ['beras', 'non_beras'],
            'pekarangan' => [
                'peternakan', 'perikanan', 'warung_hidup',
                'lumbung_hidup', 'toga', 'tanaman_keras', 'tanaman_lainnya'
            ],
            'industri_rumah_tangga' => ['industri_pangan'],
        ],
    ],

    'sandang' => [
        'name' => 'Program Sandang',
        'table' => 'laporan_sandang',
        'kader_column' => 'kader_sandang',
        'columns' => [
            'kader_sandang'    => 'Kader Sandang',
            'industri_sandang' => 'IRT Sandang',
            'jasa'             => 'Jasa',
        ],
        'groups' => [
            'kader' => ['kader_sandang'],
            'industri_rumah_tangga' => ['industri_sandang', 'jasa'],
        ],
    ],
];
