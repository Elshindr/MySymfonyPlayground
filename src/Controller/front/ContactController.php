<?php


namespace App\Controller\front;

use App\Entity\Contact;
use App\Form\ContactType;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * Description of ContactController
 *
 * @author Elshindr
 */
class ContactController extends AbstractController{
    /**
     * @Route("/contact", name="contact")
     * @return Response
     */
   public function index(Request $req,\Swift_Mailer $mailer ):Response{
       $contact = new Contact();
       $formContact = $this->createForm(ContactType::class, $contact);
       $formContact->handleRequest($req);
       
       if($formContact->isSubmitted() && $formContact->isValid()){
           
           $this->envoiMail($mailer, $contact);
           $this->addFlash('succes', 'Message envoyé! Merci!');
           return $this->redirectToRoute('contact');
       }
       return $this->render("pages/contact.html.twig", [
           'contact' => $contact,
           'formcontact' => $formContact->createView()
       ]);
   }
   
   /**
    * @param Mailer $mailer
    * @param Contact $contact
    */
   public function envoiMail(\Swift_Mailer $mailer, Contact $contact){
   $message = (new \Swift_Message('Hello from site de voyages'))
        ->setFrom($contact->getEmail())
        ->setTo('inshainnoah@gmail.com')
        ->setBody(
            $this->renderView(
                
                'pages/_email.html.twig',
                ['contact' => $contact]
                    
            ),
            'text/html'
        )
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/registration.txt.twig',
                ['name' => $name]
            ),
            'text/plain'
        )
        */
    ;

    $mailer->send($message);

   }
   
}
