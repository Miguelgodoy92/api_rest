<?php

namespace App\Controller\Api;

use App\Entity\Direccion;
use App\Form\DireccionType;
use App\Repository\ClienteRepository;
use App\Repository\DireccionRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * @Rest\Route("/direccion")
 */

class DireccionController extends AbstractFOSRestController
{

    private $repo;

    public function __construct(DireccionRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_dir"},serializerEnableMaxDepthChecks=true)
     */
    public function createDireccion(Request $request){

        $direccion = new Direccion();
        $form = $this->createForm(DireccionType::class,$direccion);
        $form->handleRequest($request);

        if(!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad data',Response::HTTP_BAD_REQUEST);
        }

        $this->repo->add($direccion,true);
        return $direccion;
    }

    // devuelve todas las direcciones en base al id de un cliente


    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View (serializerGroups={"get_dir_cliente"}, serializerEnableMaxDepthChecks= true)
     */
    public function getDireccionesByCliente(Request $request, ClienteRepository $clienteRepository){
        $idCliente = $request->get('id');
        //1. Traerme el cliente de BD
        $cliente = $clienteRepository->find($idCliente);
        //2. Una vez tengo el cliente, compruebo si existe, si no existe devuelvo error
        if(!$cliente){
            return new JsonResponse('No se ha encontrado el cliente', Response::HTTP_NOT_FOUND);
        }
        //3.Si existe entonces busco en la tabla direccion por el campo cliente
        $direcciones = $this->repo->findBy(['cliente'=> $idCliente]);
        return $direcciones;
    }

}