<?php

namespace Homeful\References;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Homeful\References\Commands\ReferencesCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_references_table')
            ->hasCommand(ReferencesCommand::class);
    }
}
