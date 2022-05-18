<?php

namespace App\Controller;

use App\DataProvider\PlantItemDataProvider;
use App\Entity\Plant;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsController]
class CreatePlant extends AbstractController
{
    private $bookPublishingHandler;
    private PlantItemDataProvider $plantItemDataProvider;

    public function __construct(
//        BookPublishingHandle $bookPublishingHandler
//        PlantItemDataProvider $plantItemDataProvider
    )
    {
//        $this->bookPublishingHandler = $bookPublishingHandler;
    }

    public function __invoke(Plant $data): Plant
    {
        dd($data);
//        $this->bookPublishingHandler->handle($data);

        return 'hello';
    }
}
