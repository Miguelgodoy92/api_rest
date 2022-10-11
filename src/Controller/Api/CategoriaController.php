<?php

namespace App\Controller\Api;

use App\Entity\Categoria;
use App\Form\CategoriaType;
use App\Repository\CategoriaRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Rest\Route("/categoria")
 */

class CategoriaController extends AbstractFOSRestController
{

    private $categoriaRepository;

    public function __construct(CategoriaRepository $repo){

        $this->categoriaRepository = $repo;
    }

    /**
     * @Rest\Get (path="/")
     * @Rest\View (serializerGroups={"get_categorias"},serializerEnableMaxDepthChecks=true)
     */

    public function getCategorias(){
        return $this->categoriaRepository->findAll();
    }

    /**
     * @Rest\Post (path="/")
     * @Rest\View (serializerGroups={"post_categorias"},serializerEnableMaxDepthChecks=true)
     */

    public function createCategoria(Request $request){
        //Formularios
        // 1. Creo el objeto vacio
        $cat = new Categoria();
        //2. Inicializamos el form
        $form = $this->createForm(CategoriaType::class,$cat);
        //3. Le decimos al formulario que maneje la request
        $form->handleRequest($request);
        //4. Comprobar que no hay error
        if (!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad data',Response::HTTP_BAD_REQUEST);
        }

        //5. Toodo ok guardo en BD
        $categoria = $form->getData();
        $this->categoriaRepository->add($categoria,true);
        return $categoria;
    }

    //traer una categoria
    /**
     * @Rest\Get (path="/{id}")
     * @Rest\View(serializerGroups={"get_categoria"},serializerEnableMaxDepthChecks=true)
     */
    public function getCategoria(Request $request){
        $idCategoria = $request->get('id');
        $categoria = $this->categoriaRepository->find($idCategoria);

        if(!$categoria){
            return new JsonResponse("No se ha encontrado categoria",Response::HTTP_NOT_FOUND);
        }
        return $categoria;

    }

    // Update con patch

    /**
     * @Rest\Patch (path="/{id}")
     * @Rest\View  (serializerGroups={"up_categoria"},serializerEnableMaxDepthChecks=true)
     */

    public function updateCategoria(Request $request){
        // Me guardo la categoria
        $categoriaId = $request->get('id');
        // OJO comprobar que existe esa categoria
        $categoria = $this->categoriaRepository->find($categoriaId);

        if(!$categoria){
            return new JsonResponse("No se ha encontrado categoria",Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(CategoriaType::class,$categoria,['method'=>$request->getMethod()]);
        $form ->handleRequest($request);
        // Tenemos que comprobar la validez del form
        if(!$form->isSubmitted() || !$form->isValid()){
            return new JsonResponse('Bad data',400);
        }

        $this->categoriaRepository->add($categoria,true);
        return $categoria;
    }

    //Delete
    /**
     * @Rest\Delete(path="/{id}")
     *
     */

    public function deleteCategoria(Request $request){
        $categoriaId = $request->get('id');
        $categoria = $this->categoriaRepository->find($categoriaId);

        if(!$categoria){
            return new JsonResponse('No se ha encontrado',400);
        }

        $this->categoriaRepository->remove($categoria,true);
        return new JsonResponse('Categoria borrada',200);
    }




//    /**
//     * @Rest\Post (path="/")
//     * @Rest\View (serializerGroups={"post_categorias"},serializerEnableMaxDepthChecks=true)
//     */
//
//    public function createCategoria(Request $request){
//        $categoria = $request->get('categoria');
//
//        if (!$categoria){
//            return new JsonResponse('Error en la peticion',Response::HTTP_BAD_REQUEST);
//        }
//
//        // Crear el objeto y hacer un set con el nombre de la categoria que he recibido
//        $cat = new Categoria();
//        $cat->setCategoria($categoria);
//        // Guardamos en la base de datos
//        $this->categoriaRepository->add($cat,true);
//        // enviar una respueste al cliente
//        return $cat;
//
//    }

}