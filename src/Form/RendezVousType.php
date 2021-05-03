<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\RendezVous;
use App\Entity\Service;
use App\Entity\Utilisateur;
use App\Repository\ServiceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('start')
            ->add('end')
            ->add('description')
            ->add('all_day')
            ->add('background_color')
            ->add('border_color')
            ->add('text_color')
            ->add('patient',EntityType::class,[
                'class' => Patient::class,
                'choice_label' => 'email'])
            ->add('utilisateur',EntityType::class,[
                'class' => Utilisateur::class,
                'choice_label' => 'email'])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
