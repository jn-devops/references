<?php

namespace Homeful\References\Tests;

use Homeful\KwYCCheck\Providers\EventServiceProvider as KyWCCheckEventServiceProvider;
use Homeful\Contracts\Providers\EventServiceProvider as ContractEventServiceProvider;
use Homeful\Mortgage\Providers\EventServiceProvider as MortgageEventServiceProvider;
use Spatie\SchemalessAttributes\SchemalessAttributesServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Homeful\References\ReferencesServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Homeful\Contracts\ContractsServiceProvider;
use Homeful\KwYCCheck\KwYCCheckServiceProvider;
use Homeful\Contacts\ContactsServiceProvider;

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
            ContractsServiceProvider::class,
            SchemalessAttributesServiceProvider::class,
            MortgageEventServiceProvider::class,
            ContactsServiceProvider::class,
            ContractEventServiceProvider::class
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        config()->set('data.validation_strategy', 'always');
        config()->set('data.max_transformation_depth', 6);
        config()->set('data.throw_when_max_transformation_depth_reached', 6);

        $migration = include __DIR__.'/../database/migrations/create_inputs_table.php.stub';
        $migration->up();
    }
}
