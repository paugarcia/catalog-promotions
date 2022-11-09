<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /** @var string */
    private const VAR_DIRECTORY_PATH = '/var';

    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }

    public function getRootPath(): string
    {
        return dirname(__DIR__, 2);
    }


    public function getCacheDir(): string
    {
        return $this->getRootPath() . self::VAR_DIRECTORY_PATH . DIRECTORY_SEPARATOR . $this->environment . '/cache';
    }

    public function getLogDir(): string
    {
        return $this->getRootPath() . self::VAR_DIRECTORY_PATH . DIRECTORY_SEPARATOR . $this->environment . '/log';
    }

}
