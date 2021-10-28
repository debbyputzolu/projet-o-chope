<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit9a94f6155df06af9b31553f2473af87b
{
    public static $prefixLengthsPsr4 = array (
        'O' => 
        array (
            'OChope\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'OChope\\' => 
        array (
            0 => __DIR__ . '/../..' . '/class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit9a94f6155df06af9b31553f2473af87b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit9a94f6155df06af9b31553f2473af87b::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit9a94f6155df06af9b31553f2473af87b::$classMap;

        }, null, ClassLoader::class);
    }
}
