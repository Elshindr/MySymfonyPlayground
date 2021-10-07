<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\admin;

use App\Entity\Visite;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




/**
 * Description of AdminVoyagesController
 *
 * @author Elshindr
 */
class AdminVoyagesController extends AbstractController{
    /**
     *
     * @var VisiteRepository
     */
    private $repository;
    
    /**
     *
     * @var EntityManagerInterface 
     */
    private $om;
    
     /**
      * 
      * @param VisiteRepository $repo
      * @param EntityManagerInterface $om
      */
    public function __construct(VisiteRepository $repo, EntityManagerInterface $om){
        $this->repository = $repo;
        $this->om=$om;
    }
    
    /**
     * @Route("/admin", name="admin.voyages")
     * @return Response
     */
    public function index():Response{
        $visites = $this->repository->findAllOrderBy('datecreation','DESC');
        
        return $this->render("admin/admin.voyages.html.twig", ['visites' => $visites]);
    }
    
    /**
     * @Route("/admin/suppr/{id}", name="admin.voyage.suppr")
     * @param Visite $visite
     * @return Response
     */
    public function suppr(Visite $visite): Response{
        $this->om->remove($visite);
        $this->om->flush();
        return $this->redirectToRoute('admin.voyages');
    }
}
