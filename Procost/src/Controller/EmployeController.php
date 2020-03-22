<?php


namespace App\Controller;
use App\Type\EmployeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Employer;

class EmployeController extends  AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    /**
     * @Route("/employe/" , name="employe" , methods={"GET"})
     */
    public  function showall() : Response{
$em = $this->getDoctrine()->getManager();
$employer= $em->getRepository(Employer::class);
        return $this->render('emp/list-emp.html.twig' , [
'employer' => $employer->findAll(),

        ]);

    }
    /**
 * @Route("/employe/ajout/" , name="employe_aj" )
 */
    public function ajout(Request $request) : Response{
        $employer = new Employer();
        $form = $this->createForm(EmployeType::class, $employer);


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($employer);
            $this->em->flush();

            return $this->redirectToRoute('employe');
        }

        return $this->render('emp/form-ajout-emp.html.twig', [
            'form' => $form->createView(),
        ]);




    }

/**
 * @Route("/employe/modif/{id}" , name="employe_modif" )
 */
public function modif(Request $request , $id) : Response{
$em=$this->getDoctrine()->getManager();
    $employer= $em->getRepository(Employer::class)->find($id);
    $form = $this->createForm(EmployeType::class, $employer);


    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {

        $employer->setPrenom($employer->getPrenom());
        $employer->setNom($employer->getNom());
        $employer->setEmail($employer->getEmail());
        $employer->setMetier($employer->getMetier());
        $employer->setCout($employer->getCout());
        $employer->setDateEmbauche($employer->getDateEmbauche());
        $this->em->flush();

        return $this->redirectToRoute('employe');
    }
    return $this->render('emp/form-modif-emp.html.twig',[
        'form' => $form->createView(),

    ] );


}

/**
 * @Route("/employe/detail/{id}" , name="employe_detail" )
 */
public function detail($id) : Response{
    $em=$this->getDoctrine()->getManager();
    $employer= $em->getRepository(Employer::class)->find($id);
    return $this->render('emp/detail-emp.html.twig' ,[

        'employer' => $employer
    ]);


}
}


