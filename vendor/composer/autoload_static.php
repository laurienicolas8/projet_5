<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite18fb6cb2d92762e8bdfcc40ad958b80
{
    public static $classMap = array (
        'AltoRouter' => __DIR__ . '/..' . '/altorouter/altorouter/AltoRouter.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInite18fb6cb2d92762e8bdfcc40ad958b80::$classMap;

        }, null, ClassLoader::class);
    }
}
