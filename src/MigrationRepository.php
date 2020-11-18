<?php
declare(strict_types=1);

namespace ieov\MigrationVs;

use Dibi\Connection;

class MigrationRepository
{

    /** @var Connection */
    private $connection;

    /** @var string */
    private $tableName;

    public function __construct(Connection $connection, string $tableName)
    {
        $this->connection = $connection;
        $this->tableName = $tableName;
    }

    public function initialize()
    {
        $this->connection->query(
            "CREATE TABLE IF NOT EXISTS %n (
            `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `time` DATETIME NOT NULL,
            `status` TINYINT(1) NOT NULL DEFAULT '0',
            PRIMARY KEY (`id`),
            UNIQUE INDEX `name` (`name`)
            );",
            $this->tableName
        );
    }

    public function findMigrationByName(string $name): ?Migration
    {
        $query = $this->connection->select('id, name, status, time')
            ->from($this->tableName)
            ->where('name = %s', $name);

        $result = $query->fetch();
        if ($result === null) {
            return null;
        }

        $migration = new Migration();
        $migration->setId($result['id']);
        $migration->setName($result['name']);
        $migration->setTime($result['time']);
        $migration->setStatus($result['status']);
        return $migration;
    }

    public function newMigration(Migration $migration): void
    {
        $this->connection->insert($this->tableName, [
            'name%s' => $migration->getName(),
            'status%i' => $migration->getStatus(),
            'time%dt' => $migration->getTime()
        ])->execute();
    }

    public function updateMigration(Migration $migration): void
    {
        $this->connection->update($this->tableName, [
            'status%i' => $migration->getStatus(),
            'time%dt' => $migration->getTime()
        ])->where('id = %i', $migration->getId())->execute();
    }

}
