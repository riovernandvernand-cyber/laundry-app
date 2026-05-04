<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $protocol = 'smtp';
    public $SMTPHost = 'smtp.gmail.com';
    public $SMTPUser = 'riovernandvernand@gmail.com';
    public $SMTPPass = 'mnxu saun vjrb pfpe'; // ← INI
    public $SMTPPort = 587;
    public $SMTPCrypto = 'tls';

    public $mailType = 'html';
    public $charset = 'utf-8';
    public $newline = "\r\n";
}