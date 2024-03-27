<?php
namespace App\Controller;

use App\Entity\Regime;
use App\Entity\Plat;
use App\Entity\Image;
use App\Entity\PropertySearch;
use App\Service\QuoteService;
use App\Form\PlatType;
use App\Form\ImageType;
use App\Form\RegimeType;
use App\Form\PropertySearchType;
use App\Repository\RegimeRepository;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Routing\Annotation\Route ;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MainController extends AbstractController
{


  #[Route('/welcome', name: 'welcome')]
    public function welcome(QuoteService $quoteService): Response
    {
        $quotes = $quoteService->getRandomQuote();

        return $this->render('welcome/welcome.html.twig', [
            'controller_name' => 'MainController',
            'quotes' => $quotes,
        ]);}



        #[Route('/home', name: 'home')]
public function home(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $regimes = $this->getDoctrine()->getRepository(Regime::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        
        $nom = $propertySearch->getNom();
        if ($nom != "") {
            // If a name is provided, display regimes with that name
            $regimes = $this->getDoctrine()->getRepository(Regime::class)->findBy(['nomregime' => $nom]);
        }
    }

    return $this->render('Regime/index.html.twig', ['form' => $form->createView(), 'regimes' => $regimes]);
}

        

 
 /**
 * @Route("/regime/new", name="new_regime")
 * Method({"GET", "POST"})
 */
public function newR(Request $request)
{
    $regime = new Regime();

    $form = $this->createForm(RegimeType::class, $regime);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $nomRegime = $regime->getNomregime(); // Get the name of the regime

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($regime);
        $entityManager->flush();

        // Update the flash message to include the name of the regime
        $this->addFlash('notice', 'New regime "' . $nomRegime . '" created successfully.');

        return $this->redirectToRoute('home');
    }

    return $this->render('Regime/ajout.html.twig', ['form' => $form->createView()]);
}



      

      /**
     * @Route("/regime/{id}", name="regime_show")
     */
    public function show($id) {
      $regime = $this->getDoctrine()->getRepository(Regime::class)->find($id);

      return $this->render('Regime/show.html.twig', array('regime' => $regime));
    }



   /**
 * @Route("/regime/edit/{id}", name="edit_regime")
 * Method({"GET", "POST"})
 */
public function edit(Request $request, $id) {
  $entityManager = $this->getDoctrine()->getManager();
  $regime = $entityManager->getRepository(Regime::class)->find($id);

  if (!$regime) {
      throw $this->createNotFoundException(
          'Pas de régime avec l\'ID ' . $id
      );
  }

  $form = $this->createFormBuilder($regime)
      ->add('nomregime', TextType::class)
      ->add('duree', IntegerType::class)
      ->add('type', TextType::class)
      ->add('save', SubmitType::class, array(
          'label' => 'Modifier',
          'attr' => ['class' => 'btn btn-success']  
      ))
      ->getForm();

  $form->handleRequest($request);

  if ($form->isSubmitted() && $form->isValid()) {
      $nomRegime = $regime->getNomregime();

      $entityManager->flush();

      $this->addFlash('notice', 'Le régime ' . $nomRegime . ' a été modifié avec succès.');

      return $this->redirectToRoute('home');
  }

  return $this->render('Regime/edit.html.twig', ['form' => $form->createView()]);
}


   /**
 * @Route("/regime/delete/{id}",name="delete_regime")
 */
public function delete(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $regime = $entityManager->getRepository(Regime::class)->find($id);
    if (!$regime) {
        throw $this->createNotFoundException(
            'Pas de régime avec l\'ID ' . $id
        );
    }

    foreach ($regime->getPlats() as $plat) {
        $plat->setRegime(null);
    }

    $nomregime = $regime->getNomregime();

    $entityManager->remove($regime);
    $entityManager->flush();
    
    $this->addFlash('notice', 'Le régime ' . $nomregime . ' a été supprimé avec succès.');

    return $this->redirectToRoute('home');
}


  
#[Route('/home2', name: 'home2')]
public function home2(Request $request)
{
    $propertySearch = new PropertySearch();
    $form = $this->createForm(PropertySearchType::class, $propertySearch);
    $form->handleRequest($request);

    // Fetch all regimes by default
    $plats = $this->getDoctrine()->getRepository(Plat::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $nom = $propertySearch->getNom();
        if ($nom != "") {
            // If a name is provided, display regimes with that name
            $plats = $this->getDoctrine()->getRepository(Plat::class)->findBy(['nomplat' => $nom]);
        }
    }

    return $this->render('Plat/indexP.html.twig', ['form' => $form->createView(), 'plats' => $plats]);
}


      
    /**
 * @Route("/plat/new", name="new_plat")
 * Method({"GET", "POST"})
 */
public function newPlat(Request $request): Response
{
    $plat = new Plat();
    
    $form = $this->createForm(PlatType::class, $plat);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
         

        $nomPlat = $plat->getNomplat(); // Get the name of the plat

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($plat);
        $entityManager->flush();

        // Update the flash message to include the name of the plat
        $this->addFlash('notice', 'New plat "' . $nomPlat . '" created successfully.');

        return $this->redirectToRoute('home2');
    }

    return $this->render('Plat/new.html.twig', ['plat' => $plat,'form' => $form->createView()]);
}



  /**
     * @Route("/plat/{id}", name="plat_show")
     */
    public function showP($id) {
        $plat = $this->getDoctrine()->getRepository(Plat::class)->find($id);
  
        return $this->render('Plat/showP.html.twig', array('plat' => $plat));
      }
  
/**
 * @Route("/plat/edit/{id}", name="edit_plat")
 * Method({"GET", "POST"})
 */
public function editP(Request $request, $id) {
  $entityManager = $this->getDoctrine()->getManager();
  $plat = $entityManager->getRepository(Plat::class)->find($id);

  if (!$plat) {
      throw $this->createNotFoundException(
          'Pas de plat avec l\'ID ' . $id
      );
  }

  $form = $this->createFormBuilder($plat)
      ->add('nomplat', TextType::class)
      ->add('cout', IntegerType::class)
      ->add('nbrcalories', IntegerType::class)
      ->add('ingredients', TextType::class)
      ->add('regime', EntityType::class, [
          'class' => 'App\Entity\regime',
          'choice_label' => 'nomregime',
          'multiple' => false,
      ])
      ->add('image', EntityType::class, [
        'class' => Image::class,
        'choice_label' => 'url',
    ])
      ->add('save', SubmitType::class, array(
          'label' => 'Modifier',
          'attr' => ['class' => 'btn btn-success']
      ))
      ->getForm();

  $form->handleRequest($request);

  if ($form->isSubmitted() && $form->isValid()) {
      $nomPlat = $plat->getNomplat();

      $entityManager->flush();

      $this->addFlash('notice', 'Le plat ' . $nomPlat . ' a été modifié avec succès.');

      return $this->redirectToRoute('home2');
  }

  return $this->render('Plat/editP.html.twig', ['form' => $form->createView()]);
}




/**
 * @Route("/plat/delete/{id}",name="delete_plat")
 */
public function deleteP(Request $request, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    $plat = $entityManager->getRepository(Plat::class)->find($id);

    if (!$plat) {
        throw $this->createNotFoundException(
            'Pas de plat avec l\'ID ' . $id
        );
    }

    $nomplat = $plat->getNomplat();

    $entityManager->remove($plat);
    $entityManager->flush();

    $this->addFlash('notice', 'Le plat ' . $nomplat . ' a été supprimé avec succès.');

    return $this->redirectToRoute('home2');
}




}