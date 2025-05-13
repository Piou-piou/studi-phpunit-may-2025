<?php

namespace Tests;

use PDO;

trait DbConnectionTrait
{
    public function testDbConnection(): PDO
    {
        $pdo = new PDO('mysql:host=mysql;dbname=phpunit;port=3306', 'root');

        $this->assertInstanceOf(PDO::class, $pdo);

        return $pdo;
    }

    public function testDbFailureConnection()
    {
        try {
            $pdo = new PDO('mysql:host=mysql;dbname=phpuni;port=3306', 'root');
        } catch (\PDOException $e) {
            $pdo = $e;
        }

        $this->assertInstanceOf(\PDOException::class, $pdo);
    }
}