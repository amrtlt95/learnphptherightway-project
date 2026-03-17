<?php

require 'vendor/autoload.php';
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Migrations\Configuration\EntityManager\ExistingEntityManager;
use Doctrine\Migrations\DependencyFactory;
use Doctrine\Migrations\Configuration\Migration\PhpFile;
use Doctrine\DBAL\DriverManager;
use \Dotenv\Dotenv;
use App\Config;


require_once __DIR__ . '/vendor/autoload.php';



$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$config = (new Config($_ENV))->db;


$connectionParams = [
    'dbname' => $config['dbname'],
    'user' => $config['user'],
    'password' => $config['password'],
    'host' => $config['host'],
    'driver' => $config['driver'],
];
$conn = DriverManager::getConnection($connectionParams);


$config = new PhpFile('migrations.php'); // Or use one of the Doctrine\Migrations\Configuration\Configuration\* loaders


$entityManager =  new EntityManager($conn, ORMSetup::createAttributeMetadataConfiguration([__DIR__ . "/app/Entity"], true));

return DependencyFactory::fromEntityManager($config, new ExistingEntityManager($entityManager));
