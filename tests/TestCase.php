<?php

namespace Homeful\References\Tests;

use Homeful\Contacts\ContactsServiceProvider;
use Homeful\Contracts\ContractsServiceProvider;
use Homeful\KwYCCheck\KwYCCheckServiceProvider;
use Homeful\KwYCCheck\Providers\EventServiceProvider as KyWCCheckEventServiceProvider;
use Homeful\References\ReferencesServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\SchemalessAttributes\SchemalessAttributesServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Homeful\\References\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ReferencesServiceProvider::class,
            KwYCCheckServiceProvider::class,
            ContactsServiceProvider::class,
            SchemalessAttributesServiceProvider::class,
            KyWCCheckEventServiceProvider::class,
            ContractsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        $migration = include __DIR__.'/../database/migrations/create_inputs_table.php.stub';
        $migration->up();
    }
}
