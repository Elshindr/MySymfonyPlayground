<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Tests\Validations;

use App\Entity\Visite;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Description of VisiteValidationTest
 *
 * @author Elshindr
 */
class VisiteValidationTest extends KernelTestCase{
    /**
     * 
     * @return Visite
     */
    public function getVisite(): Visite{
        return (new Visite())
            ->setVille("New York")
            ->setPays("USA");
    }
    
    public function assertErrors(Visite $visite, int $nbErrorsAttendues, string $message=""){
        self::bootKernel();
        $error = self::$container->get('validator')->validate($visite);
        $this->assertCount($nbErrorsAttendues, $error, $message);
    }
    
    
    public function testValidNoteVisite(){
        
        $this->assertErrors($this->getVisite()->setNote(10),0, "note = 10 devrait reussir");
        $this->assertErrors($this->getVisite()->setNote(0), 0,"note = 0 devrait reussir");
        $this->assertErrors($this->getVisite()->setNote(20), 0, "note = 20 devrait reussir");
    }
    
    public function testNonValidNoteVisite(){
        $this->assertErrors($this->getVisite()->setNote(21), 1,"note = 21 devrait echouer");
        $this->assertErrors($this->getVisite()->setNote(-1), 1, "note = -1 devrait echouer");
        $this->assertErrors($this->getVisite()->setNote(33), 1, "note = 33 devrait echouer");
        $this->assertErrors($this->getVisite()->setNote(-11), 1, "note = -11 devrait echouer");
    }
    
    
    
    public function testNonValidTempmaxVisite(){
        
        $this->assertErrors($this->getVisite()->setTempmin(20)->setTempmax(16), 1, "min=20 et max=16 devrait echouer");
        $this->assertErrors($this->getVisite()->setTempmin(20)->setTempmax(0), 1, "min=20 et max=0 devrait echouer");
        $this->assertErrors($this->getVisite()->setTempmin(13)->setTempmax(13), 1, "min=13 et max=13 devrait echouer");
    }
    
    public function testValidTempmaxVisite(){
        $this->assertErrors($this->getVisite()->setTempmin(18)->setTempmax(20), 0, "min=2 et max=33 devrait reussir");
        $this->assertErrors($this->getVisite()->setTempmin(-2)->setTempmax(-1), 0, "min=-2 et max=-1 devrait reussir");
    }
    
     public function testValidDatecreationVisite(){ 
        $aujourdhui = new \DateTime();
        $this->assertErrors($this->getVisite()->setDatecreation($aujourdhui), 0, "aujourd'hui devrait réussir");
        $plustot = (new \DateTime())->sub(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustot), 0, "plus tôt devrait réussir");
    }
    
    public function testNonValidDatecreationVisite(){ 
        $demain = (new \DateTime())->add(new \DateInterval("P1D"));
        $this->assertErrors($this->getVisite()->setDatecreation($demain), 1, "demain devrait échouer");
        $plustard = (new \DateTime())->add(new \DateInterval("P5D"));
        $this->assertErrors($this->getVisite()->setDatecreation($plustard), 1, "plus tard devrait échouer");
    }
}
