<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit77677bfd4c4243ac0c3ee192fc3360a1
{
    public static $prefixLengthsPsr4 = array (
        'K' => 
        array (
            'Klein\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Klein\\' => 
        array (
            0 => __DIR__ . '/..' . '/klein/klein/src/Klein',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit77677bfd4c4243ac0c3ee192fc3360a1::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit77677bfd4c4243ac0c3ee192fc3360a1::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
