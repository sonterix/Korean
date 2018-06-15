<?php

namespace app\controller;

use app\model\DbModel as DbModel;
use app\model\DataModel as DataModel;
use Slim\Views\Twig as View;

class FrontController
{
    private $container;
    private $dataModel;  

    public function __construct()
    {   
        // Get container
        $this->container = $GLOBALS['app']->getContainer();
        $this->dataModel = new DataModel($this->container->get('settings'));
    }

    public function home($request, $response)
    {
        $dataForView = $this->dataModel->getAllData();
        return $this->container->view->render($response, 'home.twig', ['data' => $dataForView]);
    }

    public function getDataForNewDorama($request, $response)
    {
        $dataForView = [
            'country' => $this->dataModel->getCountry(),
            'channel' => $this->dataModel->getChannel(),
            'statust' => $this->dataModel->getStatus(),
            'producer' => $this->dataModel->getProducer(),
            'genre' => $this->dataModel->getGenre(),
        ];
        return $this->container->view->render($response, 'addDorama.twig', $dataForView); 
    }

    public function addNewDorama($request, $response)
    {
        $this->dataModel->insertNewDorama($request->getParsedBody());
        return $response->withRedirect('/');
    }

    public function getDataForEditDorama($request, $response, $args)
    {
        $dataForView = [
            'data' => $this->dataModel->getDoramaById($args['id']),
            'id' => $args['id'],
            'country' => $this->dataModel->getCountry(),
            'channel' => $this->dataModel->getChannel(),
            'statust' => $this->dataModel->getStatus(),
            'producer' => $this->dataModel->getProducer(),
            'genre' => $this->dataModel->getGenre(),
        ]; 
        return $this->container->view->render($response, 'editDorama.twig', $dataForView); 
    }

    public function editDorama($request, $response)
    {
        $this->dataModel->updateDorama($request->getParsedBody());
        return $response->withRedirect('/');
    }

    public function deleteDorama($request, $response)
    {
        $this->dataModel->deleteDorama($request->getParam('element'));

    }

}