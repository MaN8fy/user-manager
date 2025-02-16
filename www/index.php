<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('pcre.backtrack_limit', '100000000');

umask(0000);

require __DIR__ . '/../vendor/autoload.php';

if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
  $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
  $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
  $ip = $_SERVER['REMOTE_ADDR'];
}


//DOMAINS
define('DOMAIN_PROD', 'users.cz');
define('DOMAIN_DEVEL', 'dev.users.cz');
define('DOMAIN_LOCAL', 'users.localhost');

define('WWW_DIR', __DIR__);
define('APP_DIR', WWW_DIR . '/../app');
define('LOG_DIR', WWW_DIR . '/../log');
define('LIBS_DIR', WWW_DIR . '/../vendor');
define('CACHE_DIR', WWW_DIR . '/../temp/cache');
define('IP_ADDR', $ip);

\App\Booting::boot()
        ->createContainer()
        ->getByType(Nette\Application\Application::class)
        ->run();

