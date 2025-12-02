<?php

return [
    'exports' => [
        'chunk_size' => 1000,
    ],

    'imports' => [
        'read_only' => true,
        'ignore_empty' => true,
    ],

    'cache' => [
        'driver' => 'memory',
    ],

    'tmp_path' => sys_get_temp_dir(),

    'csv' => [
        'delimiter' => ',',
        'enclosure' => '"',
        'line_ending' => PHP_EOL,
        'use_bom' => false,
        'include_separator_line' => false,
        'excel_compatibility' => false,
    ],

    'sheets' => [
        'page_margin' => [
            'top' => 0.75,
            'right' => 0.75,
            'bottom' => 0.75,
            'left' => 0.75,
        ],
    ],
];
