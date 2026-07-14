<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Pager extends BaseConfig
{
    public array $templates = [
        'default_full'   => 'CodeIgniter\Pager\Views\default_full',
        'default_simple' => 'CodeIgniter\Pager\Views\default_simple',

        // ✅ pakai custom bootstrap (yang kita buat sendiri)
        'bootstrap'      => 'App\Views\pager\bootstrap',
    ];

    public int $perPage = 5;
}