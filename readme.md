**Migration VS**

Simple _nette_ extension for database migration, where some simple php operations is required.

_Usage:_

config.neon:
```
extensions:
    migrationVs: ieov\MigrationVs\DI\MigrationViaScriptDI

migrationVs:
    tableName: 'migrations_script'
    connection: @dibi.connection
    scripts:
        - SomeMigrationScript\FirstMigrationScript
        - SomeMigrationScript\SecondMigrationScript
```

MigrationVs creates table in database with name `tableName` where it simply registers
executed migrations.

Create migration `scripts`, that extend _ieov\MigrationVs\MigrationScript.php_.
These classes take dibi `connection` in constructor and implement _execute()_
method, that return integer > 0 in success.

