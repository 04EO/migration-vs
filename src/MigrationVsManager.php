<?php
declare(strict_types=1);

namespace io04\MigrationVs;

use Dibi\Connection;

class MigrationVsManager
{
    /** @var array */
    private $scripts;

    /** @var MigrationRepository */
    private $migrationRepository;

    /** @var Connection */
    private $connection;

    public function __construct(string $dbTableName, array $scripts, Connection $connection)
    {
        $this->migrationRepository = new MigrationRepository($connection, $dbTableName);
        $this->scripts = $scripts;
        $this->connection = $connection;
    }

    public function execute(): void
    {
        printf(':Script Migration Started' . PHP_EOL);
        $this->migrationRepository->initialize();
        foreach ($this->scripts as $script) {
            printf('[%s]:' . PHP_EOL, $script);
            $migration = $this->migrationRepository->findMigrationByName($script);
            if ($migration === null) {
                printf(' - execute' . PHP_EOL);
                $migrationScript = new $script($this->connection);
                if ($migrationScript instanceof MigrationScript) {
                    $status = $migrationScript->execute();
                    $migration = new Migration();
                    $migration->setStatus($status);
                    $migration->setName($script);
                    $migration->setTime(new \DateTime('now'));
                    $this->migrationRepository->newMigration($migration);
                    if ($status > 0) {
                        printf(' - script finished: SUCCESS' . PHP_EOL);
                    } else {
                        printf(' - script finished: FAIL' . PHP_EOL);
                    }
                } else {
                    printf(' - SCRIPT MUST BE IMigrationScript TYPE' . PHP_EOL);
                }
            } elseif ($migration->isDone()) {
                printf(' - already done' . PHP_EOL);
            } else {
                $migrationScript = new $script($this->connection);
                if ($migrationScript instanceof MigrationScript) {
                    $status = $migrationScript->execute();
                    $migration->setStatus($status);
                    $migration->setTime(new \DateTime('now'));
                    $this->migrationRepository->updateMigration($migration);
                    if ($status > 0) {
                        printf(' - script finished: SUCCESS' . PHP_EOL);
                    } else {
                        printf(' - script finished: FAIL' . PHP_EOL);
                    }
                } else {
                    printf(' - SCRIPT MUST BE IMigrationScript TYPE' . PHP_EOL);
                }
            }
        }
    }

}
