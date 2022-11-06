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
        $productMongoRepo = new ProductMongoRepository();
        
        $saveProductApplicationService = new SaveProductApplicationService($productMongoRepo);
        $saveProductCommandHandler = new SaveProductCommandHandler($saveProductApplicationService);

        $saveProductCommandHandler->handle(new SaveProductCommand('000001', 'BV Lean leather ankle boots', 'boots', 89000));
        $saveProductCommandHandler->handle(new SaveProductCommand('000002', 'BV Lean leather ankle boots', 'boots', 99000));
        $saveProductCommandHandler->handle(new SaveProductCommand('000003', 'Ashlington leather ankle boots', 'boots', 89000));
        $saveProductCommandHandler->handle(new SaveProductCommand('000004', 'Naima embellished suede sandals', 'sandals', 79500));
        $saveProductCommandHandler->handle(new SaveProductCommand('000005', 'Nathane leather sneakers', 'sneakers', 59000));

        echo "<pre>";
        var_dump($productMongoRepo->getAll());die;

        return new Response("Hola mundo");
    }
}