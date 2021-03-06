<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\admin;

use App\Entity\Visite;
use App\Form\VisiteType;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    
    
    /**
     * @Route("/admin/edit/{id}", name="admin.voyage.edit")
     * @param Visite $visite
     * @param Request $req
     * @return Response
     */
    public function edit(Visite $visite, Request $req): Response{
        $formVisite = $this->createForm(VisiteType::class, $visite);
        
        $formVisite->handleRequest($req);
        if($formVisite->isSubmitted() && $formVisite->isValid()){
            $this->om->flush();
            return $this->redirectToRoute('admin.voyages');
        }
        
        return $this->render("admin/admin.voyage.edit.html.twig", [
            'visite' => $visite, 
            'formvisite'=> $formVisite->createView()
        ]);
    }
    
    /**
     * @Route ("/admin/ajout", name="admin.voyage.ajout")
     * @param Request $req
     * @return Response
     */
    public function ajout(Request $req):Response{
        $visite = new Visite();
        $formVisite = $this->createForm(VisiteType::class, $visite);
        $formVisite->handleRequest($req);
        
        if($formVisite->isSubmitted() && $formVisite->isValid()){
            $this->om->persist($visite);
            $this->om->flush();
           return $this->redirectToRoute('admin.voyages');
        }
        
        return $this->render("admin/admin.voyage.ajout.html.twig",[
            'visite' => $visite,
            'formvisite' => $formVisite->createView()
        ]);
        
        
        
    }
}
