<?php

namespace Tests;

use PDO;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    use DbConnectionTrait;

    #[Depends('testDbConnection')]
    public function testGetUsers(PDO $pdo)
    {
        $query = $pdo->query("SELECT * FROM user LIMIT 10");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $this->assertIsArray($result);

        return $result;
    }

    #[Depends('testGetUsers')]
    public function testLoopUsers(array $users)
    {
        foreach ($users as $user) {
            $this->assertIsString($user['firstname']);
            $this->assertIsString($user['lastname']);

            $this->assertThat(
                $user['username'],
                $this->logicalOr(
                    $this->isString(),
                    $this->isNull()
                )
            );
        }
    }

    #[Depends('testDbConnection')]
    public function testInsertUser(PDO $pdo)
    {
        $query = $pdo->prepare('insert into user set firstname=:firstname, lastname=:lastname');
        $query->bindValue('firstname', 'Anthony');
        $query->bindValue('lastname', 'Testinsert');

        $this->assertTrue($query->execute());

        return (int) $pdo->lastInsertId();

    }

    #[Depends('testDbConnection')]
    #[Depends('testInsertUser')]
    public function testGetUser(PDO $pdo, int $id)
    {
        $query = $pdo->prepare('select * from user where id = :id');
        $query->bindParam('id', $id);
        $query->execute();

        $user = $query->fetch(PDO::FETCH_ASSOC);

        $this->assertIsArray($user);
        $this->assertSame('Anthony', $user['firstname']);
        $this->assertSame('Testinsert', $user['lastname']);
        $this->assertNull($user['username']);
    }
}