<?php

namespace App\Form;

use App\Entity\Lit;
use App\Entity\Patient;
use App\Entity\Service;
use App\Repository\LitRepository;
use App\Repository\PatientRepository;
use App\Repository\ServiceRepository;
use phpDocumentor\Reflection\Types\True_;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class PatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Nom')
            ->add('Prenom')
            ->add('Age', IntegerType::class)
            ->add('Sexe', ChoiceType::class,[
                'choices'=>[
                    'Sexe'=> [
                        'Masculin' => True,
                        'Feminin' => False
                    ]
                ]
            ])
            ->add('Adresse')
            ->add('Ville')
            ->add('CodePostal')
            ->add('Email',EmailType::class)
            ->add('Telephone')
            ->add('Service',EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'NomService',
                'query_builder' => function (ServiceRepository $er) {
                     return $er->createQueryBuilder('service')
                        ->where('service.NomService not Like :id')
                        ->setParameter('id','Administration')
                        ;
    },
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }


}
