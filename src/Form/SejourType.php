<?php

namespace App\Form;

use App\Entity\Patient;
use App\Entity\Sejour;
use App\Entity\Service;
use App\Repository\PatientRepository;
use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SejourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('DateEntree',DateType::class)
            ->add('DateSortie',DateType::class)
            ->add('Patient',EntityType::class,[
                'class' => Patient::class,
                'choice_label' => 'Nom',
                'disabled' => true
            ])
            ->add('Service',EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'NomService',
                'disabled' => true
            ])
            ->add('Valider',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sejour::class,
        ]);
    }
}
