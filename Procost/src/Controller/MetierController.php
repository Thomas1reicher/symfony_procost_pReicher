<?php


namespace App\Controller;
use App\Type\MetierType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Metier;

class MetierController extends  AbstractController
{

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }
    /**
     * @Route("/metier/" , name="metier" , methods={"GET"})
     */
    public  function metier() : Response{
        $em = $this->getDoctrine()->getManager();
        $employer= $em->getRepository(Metier::class);
        return $this->render('metier/list-met.html.twig' , [
            'metier' => $employer->findAll(),

        ]);


    }
    /**
     * @Route("/metier/ajout" , name="metier_ajout" )
     */
    public  function ajout(Request $request) : Response{
        $metier = new Metier();
        $form = $this->createForm(MetierType::class, $metier);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($metier);
            $this->em->flush();

            return $this->redirectToRoute('metier');
        }

        return $this->render('metier/form-ajout-met.html.twig', [
            'form' => $form->createView(),
        ]);


    }
    /**
     * @Route("/metier/modif/{id}" , name="metier_modif" )
     */
    public  function modif(Request $request,$id) : Response{
        $em=$this->getDoctrine()->getManager();
        $metier= $em->getRepository(Metier::class)->find($id);
        $form = $this->createForm(MetierType::class, $metier);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $metier->setMetierTitre($metier->getMetierTitre());
            $metier->setDescription($metier->getDescription());
            $this->em->flush();

            return $this->redirectToRoute('metier');
        }
        return $this->render('metier/form-modif-met.html.twig',[
            'form' => $form->createView(),

        ] );


    }
}
