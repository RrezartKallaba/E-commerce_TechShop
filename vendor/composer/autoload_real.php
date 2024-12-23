<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitf0f90ac369f921da93b7046bc5eb4cc0
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

        spl_autoload_register(array('ComposerAutoloaderInitf0f90ac369f921da93b7046bc5eb4cc0', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitf0f90ac369f921da93b7046bc5eb4cc0', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitf0f90ac369f921da93b7046bc5eb4cc0::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
