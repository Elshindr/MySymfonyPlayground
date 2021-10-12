<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller\admin;

use App\Entity\Environnement;
use App\Repository\EnvironnementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of AdminEnvironnementsController
 *
 * @author Elshindr
 */
class AdminEnvironnementsController extends AbstractController {
    
    /**
     * @var EnvironnementRepository
     */
    private $repository;
            
            
    /**
     * @var EntityManagerInterface
     */        
    private $om;       
    
    /**
     * @param EnvironnementRepository $repository
     * @param EntityManagerInterface $om
     */
    public function __construct(EnvironnementRepository $repository, EntityManagerInterface $om) {
        $this->repository = $repository;
        $this->om = $om;
    }
    
    
    /**
     * @Route("/admin/environnements", name="admin.environnement")
     * @return Response
     */
    public function index():Response{
        $environnements = $this->repository->findAll();
        
        return $this->render('admin/admin.environnements.html.twig',
                ['environnements' => $environnements]);
    }
    
    /**
     * @Route("/admin/environnements/suppr/{id}", name="admin.environnement.suppr")
     * @param Environnement $environnement
     * @return Response
     */
    public function suppr(Environnement $environnement):Response{
        $this->om->remove($environnement);
        $this->om->flush();
        return $this->redirectToRoute('admin.environnement');
    }
    
    
    /**
     * @Route("/admin/environnements/ajout", name="admin.environnement.ajout")
     * @param Request $req
     * @return Response
     */
    public function ajout(Request $req): Response{
        $nomEnvir = $req->get("nom");
        $environnement = new Environnement();
        $environnement->setNom($nomEnvir);
        
        $this->om->persist($environnement);
        $this->om->flush();
        
        return $this->redirectToRoute('admin.environnement');
    }
}
