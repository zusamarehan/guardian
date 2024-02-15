<?php

namespace RehanKanak\Guardian\Tests;

use Orchestra\Testbench\Attributes\WithMigration;
use Orchestra\Testbench\TestCase as Orchestra;
use RehanKanak\Guardian\GuardianServiceProvider;

#[WithMigration]
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--realpath' => realpath(__DIR__.'/../migrations'),
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            GuardianServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'sqlite');
        config()->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }
}
