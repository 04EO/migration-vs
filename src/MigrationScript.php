<?php
declare(strict_types=1);

namespace io04\MigrationVs;

use Dibi\Connection;

abstract class MigrationScript
{
    /** @var Connection */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    abstract public function execute(): int;
}