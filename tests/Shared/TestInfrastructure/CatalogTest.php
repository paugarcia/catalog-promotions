<?php

namespace App\Tests\Shared\TestInfrastructure;

use Faker\Factory;
use PHPUnit\Framework\TestCase;

abstract class CatalogTest extends TestCase
{
    protected \Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('es_ES');
        parent::__construct();
    }

}