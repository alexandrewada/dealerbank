<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit74ec5552ccef1f3cf722cd0e7489fd9c
{
    public static $files = array (
        '04c6c5c2f7095ccf6c481d3e53e1776f' => __DIR__ . '/..' . '/mustangostang/spyc/Spyc.php',
    );

    public static $prefixLengthsPsr4 = array (
        'C' => 
        array (
            'Cnab\\' => 5,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Cnab\\' => 
        array (
            0 => __DIR__ . '/..' . '/andersondanilo/cnab_php/src/Cnab',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit74ec5552ccef1f3cf722cd0e7489fd9c::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit74ec5552ccef1f3cf722cd0e7489fd9c::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}