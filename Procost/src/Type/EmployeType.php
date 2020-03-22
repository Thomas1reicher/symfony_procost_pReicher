<?php


namespace App\Type;

use App\Entity\Metier;
use App\Entity\Employer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Select;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeType extends AbstractType
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;

    }

    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {


        $liste = $this->em->getRepository(Metier::class)->findAll();

        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('metier', ChoiceType::class, [
                'choices' => $liste,
                'label' => 'Metier',
                'required' => true,
            ])
            ->add('cout', IntegerType::class, [
                'label' => 'Cout',
                'required' => true,
            ])
            ->add('date_embauche', DateType::class, [
                'label' => "Date d'embauche",
                'required' => true,
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employer::class,
        ]);
    }
}
