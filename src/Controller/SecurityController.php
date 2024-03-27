<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    #[Route('/inscription', name: 'app_security')]
    public function registration(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $user=new User();
        $form=$this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();

            $this->addFlash('success', 'Your account has been created successfully. You can now log in.');

            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', ['form' => $form->createView()]);
    }


    /**
 * @Route("/connexion",name="security_login")
 */
public function login(AuthenticationUtils  $authenticationUtils)
{
     // get the login error if there is one
$error = $authenticationUtils->getLastAuthenticationError();

// last username entered by the user
$lastUsername = $authenticationUtils->getLastUsername();

if ($this->getUser()) {
    // If the user is already logged in, redirect to the welcome page
    return $this->redirectToRoute('welcome');
}
    
    return $this->render('security/login.html.twig',['lastUsername'=>$lastUsername,
                                                    'error' => $error]);
}

/**
 * @Route("/deconnexion",name="security_logout")
 */
public function logout()
{ 
    
}


}
