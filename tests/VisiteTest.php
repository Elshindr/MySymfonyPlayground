<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests;

use App\Entity\Environnement;
use App\Entity\Visite;
use DateTime;
use PHPUnit\Framework\TestCase;


/**
 * Description of VisiteTest
 *
 * @author Elshindr
 */
class VisiteTest extends TestCase{
    
   
    
    public function testGetDatecreationString(){
        $visite = new Visite();
        $visite->setDatecreation(new DateTime("2021-06-26"));
        
        $this->assertEquals("2021-06-26", $visite->getDatecreationString());
    }
    
    
    public function testAddEnvironnement(){
        $environnement = new Environnement();
        $environnement->setNom("plage");
        $visite = new Visite();
        $visite->addEnvironnement($environnement);
        $nbEnvironnementAvant = $visite->getEnvironnements()->count();
        $visite->addEnvironnement($environnement);
        $nbEnvironnementApres = $visite->getEnvironnements()->count();
        $this->assertEquals($nbEnvironnementAvant, $nbEnvironnementApres, "ajout même environnement devrait échouer");
    }
}
