<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;



use App\Product\Application\Commands\SaveProduct\SaveProductApplicationService;
use App\Product\Application\Commands\SaveProduct\SaveProductCommand;
use App\Product\Application\Commands\SaveProduct\SaveProductCommandHandler;

use App\Product\Infrastructure\ProductMongoRepository;


class IndexController extends AbstractController
{
    public function index() : Response
    {
        $mongoRepo = new ProductMongoRepository();

        $saveProductApplicationService = new SaveProductApplicationService($mongoRepo);
        $saveProductCommandHandler = new SaveProductCommandHandler($saveProductApplicationService);

        $saveProductCommandHandler->handle(new SaveProductCommand('000001', 'BV Lean leather ankle boots', 'boots', 89000));

        $mongoRepo->getAll();

        return new Response("Hola mundo");
    }
}