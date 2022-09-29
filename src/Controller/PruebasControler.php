<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PruebasControler extends AbstractController
{

    private $logger;
    public function __construct(LoggerInterface $logger){
        $this->logger = $logger;
    }
    // Tenemos que definir como es el endpoint para poder hacer la peticion desde el cliente
    // ENDPOINT
    /**
     * @Route("/get/usuarios",name="get_users")
     */
    public function getAllUser(Request $request){
        // llamará a base de datos y se traera toda la lista de users
        // Devolver una respuesta en formato Json
        // Request - Peticion
        // Response - Hay que devoler una respuesta
        //$response = new Response();
        //$response->setContent('<div>Hola mundo</div>');
        // Capturamos los datos que vienen del resquest
        $id = $request->get('id');
        $this->logger->alert('mensajito');
        // query sql para traer el user con id = $id

        $response = new JsonResponse();
        $response->setData([
            'succes'=>true,
            'data'=>
                [
                    'id'=>intval($id),
                    'nombre'=> 'Pepe',
                    'email'=> 'pepe@email.com'
                ]

        ]);

        return $response;

    }

}