<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitc981a0c84a10b1bfe943fe72070dc80d
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitc981a0c84a10b1bfe943fe72070dc80d', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitc981a0c84a10b1bfe943fe72070dc80d', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitc981a0c84a10b1bfe943fe72070dc80d::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
