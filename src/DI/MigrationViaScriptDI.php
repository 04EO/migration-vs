<?php
declare(strict_types=1);

namespace ieov\MigrationVs\DI;

use ieov\MigrationVs\MigrationVsManager;
use Nette\DI\CompilerExtension;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

class MigrationViaScriptDI extends CompilerExtension
{
    private const
        TABLE_NAME_PARAMETER = 'tableName',
        SCRIPTS_PARAMETER = 'scripts',
        CONNECTION_PARAMETER = 'connection';

    public function loadConfiguration()
    {
        $builder = $this->getContainerBuilder();
        $builder->addDefinition($this->prefix('scriptMigrations'))
            ->setFactory(MigrationVsManager::class, [
                $this->config->tableName,
                $this->config->scripts,
                $this->config->connection
            ]);
    }

    public function getConfigSchema(): Schema
    {
        return Expect::structure([
            self::TABLE_NAME_PARAMETER => Expect::string('script_migrations'),
			self::SCRIPTS_PARAMETER => Expect::array(),
            self::CONNECTION_PARAMETER => Expect::string()
		]);
	}
}
