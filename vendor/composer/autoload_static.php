<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit35850b4d08be639dea11f54b13242f0b
{
    public static $files = array (
        '253c157292f75eb38082b5acb06f3f01' => __DIR__ . '/..' . '/nikic/fast-route/src/functions.php',
        'f8b0b5f351aa0dc2d4b9c3b8f451115f' => __DIR__ . '/..' . '/league/json-guard/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Spatie\\ArrayToXml\\' => 18,
            'Slim\\' => 5,
        ),
        'P' => 
        array (
            'Psr\\Http\\Message\\' => 17,
            'Psr\\Container\\' => 14,
        ),
        'L' => 
        array (
            'League\\JsonGuard\\' => 17,
        ),
        'J' => 
        array (
            'JsonSchema\\' => 11,
        ),
        'I' => 
        array (
            'Interop\\Container\\' => 18,
        ),
        'F' => 
        array (
            'FastRoute\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Spatie\\ArrayToXml\\' => 
        array (
            0 => __DIR__ . '/..' . '/spatie/array-to-xml/src',
        ),
        'Slim\\' => 
        array (
            0 => __DIR__ . '/..' . '/slim/slim/Slim',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
        'Psr\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/container/src',
        ),
        'League\\JsonGuard\\' => 
        array (
            0 => __DIR__ . '/..' . '/league/json-guard/src',
        ),
        'JsonSchema\\' => 
        array (
            0 => __DIR__ . '/..' . '/justinrainbow/json-schema/src/JsonSchema',
        ),
        'Interop\\Container\\' => 
        array (
            0 => __DIR__ . '/..' . '/container-interop/container-interop/src/Interop/Container',
        ),
        'FastRoute\\' => 
        array (
            0 => __DIR__ . '/..' . '/nikic/fast-route/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'P' => 
        array (
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit35850b4d08be639dea11f54b13242f0b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit35850b4d08be639dea11f54b13242f0b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit35850b4d08be639dea11f54b13242f0b::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit35850b4d08be639dea11f54b13242f0b::$classMap;

        }, null, ClassLoader::class);
    }
}
