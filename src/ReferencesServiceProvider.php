<?php

namespace Homeful\References;

use Homeful\References\Commands\ReferencesCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ReferencesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('references')
            ->hasConfigFile(['references', 'vouchers'])
            ->hasViews()
            ->hasMigration('create_inputs_table')
            ->hasRoute('api')
            ->hasCommand(ReferencesCommand::class);
    }
}
