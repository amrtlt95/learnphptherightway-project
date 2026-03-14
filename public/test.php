<?php

declare(strict_types=1);

use Doctrine\DBAL\DriverManager;
use Dotenv\Dotenv;
use App\Config;
use Dba\Connection;
use Doctrine\DBAL\ArrayParameterType;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Types\Types;
use SebastianBergmann\CodeCoverage\Node\Builder;

require_once __DIR__ . '/../vendor/autoload.php';



$dotenv = Dotenv::createImmutable(dirname(__DIR__));
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


// $query = "SELECT * FROM emails WHERE id = :id";

// $stmt = $conn->prepare($query);
// $stmt->bindValue(":id",1);
// $result = $stmt->executeQuery()->fetch

// var_dump($result);


// $conn->executeQuery("SELECT * FROM emails WHERE id IN (?)",[1,2,3],)

// $query = "SELECT id, subject FROM emails WHERE  created_at BETWEEN :start AND :end";

// $stmt = $conn->prepare($query);

// $start = new DateTime('2026-03-08');
// $end = new DateTime("2026-03-09");
// $stmt->bindValue(":start",$start,Types::DATETIME_MUTABLE);

// $stmt->bindValue(":end",$end,Types::DATETIME_MUTABLE);
// var_dump( $stmt->executeQuery()->fetchAllAssociative());



// $query = "SELECT id, subject FROM emails WHERE  id IN (?)";


$arr = [1,2,3];

// $result = $conn->fetchAllAssociative($query,[$arr],[ArrayParameterType::INTEGER]);
// print_r($result);

// $conn->transactional()
$queryBuilder = $conn->createQueryBuilder();
$retult = $queryBuilder->select("id","subject")->from("emails")->where("id IN (?)")->setParameter(0,$arr,ArrayParameterType::INTEGER)->fetchAllAssociative();

$queryBuilder->getSQL();

// print_r(($retult));

$schema = $conn->createSchemaManager();

// $schema->listTables()

print_r($schema->listTables());