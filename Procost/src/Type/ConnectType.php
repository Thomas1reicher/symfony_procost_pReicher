<?php


namespace App\Type;

use App\Entity\Compte;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConnectType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options) : void
{
    $builder
        ->add('email', EmailType::class, [
            'label' => 'Email',
            'required' => true,
        ])
        ->add('motdepasse', TextType::class, [
            'label' => 'Mot de passe',
            'required' => true,
        ])


    ;
}

public function configureOptions(OptionsResolver $resolver): void
{
 $resolver->setDefaults([
     'data_class' => Compte::class,
 ]);
}
}
