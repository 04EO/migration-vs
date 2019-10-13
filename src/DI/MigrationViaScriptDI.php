<?php
declare(strict_types=1);

namespace ieov\MigrationVs\DI;

use Dibi\Connection;
use ieov\MigrationVs\MigrationVsManager;
use Nette\DI\CompilerExtension;

class MigrationViaScriptDI extends CompilerExtension
{

    private const
        TABLE_NAME_PARAMETER = 'tableName',
        SCRIPTS_PARAMETER = 'scripts',
        CONNECTION_PARAMETER = 'connection';

    private $defaults = [
        self::TABLE_NAME_PARAMETER => 'script_migrations',
        self::SCRIPTS_PARAMETER => [],
        self::CONNECTION_PARAMETER => null
    ];

    public function loadConfiguration()
    {
        $this->validateConfig($this->defaults);
        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('scriptMigrations'))
            ->setFactory(MigrationVsManager::class, [
                $this->config[self::TABLE_NAME_PARAMETER],
                $this->config[self::SCRIPTS_PARAMETER],
                $this->config[self::CONNECTION_PARAMETER]
            ]);
    }

}
