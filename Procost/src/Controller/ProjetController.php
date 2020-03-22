<?php


namespace App\Controller;

use App\Type\ProjetType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Projet;

class ProjetController extends  AbstractController
{

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    /**
     * @Route("/projet/" , name="projet" , methods={"GET"})
     */
    public  function projetall() : Response{
        $em = $this->getDoctrine()->getManager();
        $projet= $em->getRepository(Projet::class);
        return $this->render('proj/list-proj.html.twig' , [
            'Projet' => $projet->findAll(),

        ]);


    }
    /**
     * @Route("/projet/ajout/" , name="projet_ajout" )
     */
    public function ajout(Request $request) : Response{
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($projet);
            $this->em->flush();

            return $this->redirectToRoute('projet');
        }

        return $this->render('proj/form-ajout-proj.html.twig', [
            'form' => $form->createView(),
        ]);




    }

    /**
     * @Route("/projet/modif/{id}" , name="projet_modif" )
     */
    public function modif(Request $request , $id) : Response{
        $em=$this->getDoctrine()->getManager();
        $projet= $em->getRepository(Projet::class)->find($id);
        $form = $this->createForm(ProjetType::class, $projet);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->em->flush();

            return $this->redirectToRoute('projet');
        }
        return $this->render('proj/form-modif-proj.html.twig',[
            'form' => $form->createView(),

        ] );


    }

    /**
     * @Route("/projet/detail/{id}" , name="projet_detail" )
     */
    public function detail($id) : Response{
        $em=$this->getDoctrine()->getManager();
        $projet= $em->getRepository(Projet::class)->find($id);
        return $this->render('proj/detail-proj.html.twig' ,[

            'projet' => $projet
        ]);


    }
}


