<?php


namespace App\Controller;


use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Compte;
use App\Entity\Employer;
use App\Entity\Projet;
use App\Type\ConnectType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class TblController extends  AbstractController
{

    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    /**
     * @Route("" , name="tableau" )
     */
public  function tableau() : Response{
    $em = $this->getDoctrine()->getManager();
    $ListeProjet= $em->getRepository(Projet::class)->findAll();
    $ListeEmploye= $em->getRepository(Employer::class)->findAll();
    $nombreEmp=sizeof($ListeEmploye);
    $now=new DateTime();
    $ListeLivre=[];
    $ListeCour=[];
    $cout=0;
    $ListeProjet5=[];
    $coutmax=0;
    $topemployer= new Employer();
    $livre=0;
    $cour=0;
    for ($u=0;$u<sizeof($ListeEmploye);$u++){

$cout=$cout+$ListeEmploye[$u]->getCout();

if($ListeEmploye[$u]->getCout()>$coutmax){
    $coutmax=$ListeEmploye[$u]->getCout();
    $topemployer=$ListeEmploye[$u];


}

    }
    for ($i=0;$i<sizeof($ListeProjet);$i++){

        if($ListeProjet[$i]->getDateLivraison()<$now){
            $ListeLivre=array_push($ListeLivre,$ListeProjet[$i]);
$livre=$livre+1;
        }else{
            $ListeCour=array_push($ListeCour,$ListeProjet[$i]);
$cout=$cout+1;
        }


        if(5<sizeof($ListeProjet)) {
            if ($i > sizeof($ListeProjet) - 5) {
                $ListeProjet5 = array_push($ListeProjet5, $ListeProjet[$i]);

            }
        }
        else{

            $ListeProjet5 = array_push($ListeProjet5, $ListeProjet[$i]);
        }




    }
    $tauxlivre=(100*$livre)/sizeof($ListeProjet);
    $tauxcour=(100*$cour)/sizeof($ListeProjet);
    return $this->render('index.html.twig',[
        'nombre'=> $nombreEmp,
        'Cour'=>$ListeCour,
        'Livre'=>$ListeLivre,
        'topemployer' =>$topemployer,
        'projet' => $ListeProjet5,
        'tauxlivre' => $tauxlivre,
        'tauxcour' => $tauxcour,
        'livrenb' => $livre,
        'cournb' => $cour,
        'now' => $now,




    ]);

}
    /**
     * @Route("/connect/" , name="connect"  , methods={"GET","POST"})

     */
    public  function connect(AuthenticationUtils $authenticationUtils) : Response{
        /*/$em = $this->getDoctrine()->getManager();
        $Liste= $em->getRepository(Compte::class)->findAll();
        $compte = new Compte();
        $form = $this->createForm(ConnectType::class, $compte);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Votre demande contact a été prise en compte !');
        for ($i=0;$i<sizeof($Liste);$i++){
            if($Liste[$i]->getEmail()==$compte->getEmail()){
                if($Liste[$i]->getMotdepasse()==$compte->getMotdepasse()){

                    return $this->redirectToRoute('tableau');
                }

            }

        }

        }

        return $this->render('login.html.twig', [
            'form' => $form->createView()
        ]);*/

        if ($this->getUser()) {
            return $this->redirectToRoute('tableau');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

    }
}
