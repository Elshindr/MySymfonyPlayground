<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of VoyagesController
 *
 * @author Ydrani
 */
class VoyagesController extends AbstractController {
    /**
     *
     * @var VisiteRepository
     */
    private $repository;
    
    
    /**
     * 
     * @param VisiteRepository $repo
     */
    public function __construct(VisiteRepository $repo){
        $this->repository = $repo;
        
    }
    
    /**
     * @Route("/voyages", name ="MESPUTAINS DE PASvoyages")
     * @return Response
     */
    public function index() : Response {
        $visites = $this->repository->findAll();
       dump($visites);
        
        return $this->render("pages/voyages.html.twig", ['visites' => $visites]);
    }
    //put your code here
}
