<?php

declare(strict_types=1);

use Laminas\Pimple\Config\Config;
use Laminas\Pimple\Config\ContainerFactory;
use Symfony\Component\Dotenv\Dotenv;

$config  = require __DIR__ . '/config.php';
$factory = new ContainerFactory();

$dotenv = new Dotenv();
$dotenv->load('.env');

return $factory(new Config($config));
