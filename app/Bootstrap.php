<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;

/**
 * Booting
 */
class Booting
{
    /**
     * Booting
     * @return Configurator
     */
    public static function boot(): Configurator
    {
        $configurator = new Configurator();

        $domain = '';

        $domainParts = explode('.', $_SERVER['HTTP_HOST']);
        $domain = $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
        define('DOMAIN', $domain);
        if ($domain == DOMAIN_DEVEL) {
            define('ENV', 'DEVEL');
            $section = 'devel';
            $configurator->setDebugMode(true);
        } elseif ($domain == DOMAIN_PROD) {
            define('ENV', 'PRODUCTION');
            $section = 'production';
            $configurator->setDebugMode(false);
        } elseif ($domain == DOMAIN_LOCAL) {
            define('ENV', 'LOCAL');
            $section = 'local';
            $configurator->setDebugMode(true);
        } else {
            throw new \Exception('Cannot recognise app ENVIRONMENT. Check predefined valid URL.');
        }


        $configurator->enableTracy(__DIR__ . '/../log');

        $configurator->setTempDirectory(__DIR__ . '/../temp');

        $configurator->createRobotLoader()
            ->addDirectory(__DIR__)
            ->register();

        $configurator->addConfig(__DIR__ . '/config/config.neon');
        if ($section == 'devel_online') {
            $configurator->addConfig(__DIR__ . '/config/config.devel.neon');
        } elseif ($section == 'production') {
            $configurator->addConfig(__DIR__ . '/config/config.production.neon');
        } else {
            $configurator->addConfig(__DIR__ . '/config/config.local.neon');
        }

        return $configurator;
    }
}
