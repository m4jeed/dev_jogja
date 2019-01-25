<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd56b361dcf724a43f0b11b2e1b549cdf
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd56b361dcf724a43f0b11b2e1b549cdf::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd56b361dcf724a43f0b11b2e1b549cdf::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}