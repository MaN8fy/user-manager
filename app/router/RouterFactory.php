<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;

/**
 * Router factory.
 */
final class RouterFactory
{
    use Nette\StaticClass;

    /**
     * Create router
     *
     * @return RouteList
     */
    public static function createRouter(): RouteList
    {
        $router = new RouteList();

        $router->withModule('Sys')
            ->addRoute('<presenter>/<action>', 'Homepage:default');
        $router->withModule('Public')
            ->addRoute('public/<presenter>/<action>', 'Homepage:default');
        return $router;
    }
}
