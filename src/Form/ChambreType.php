<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Lit;
use App\Repository\ChambreRepository;
use App\Repository\LitRepository;
use App\Entity\Service;
use App\Repository\ServiceRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('NombreLit', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class)
            ->add('Service',EntityType::class,[
                'class' => Service::class,
                'choice_label' => 'NomService',
                'query_builder' => function (ServiceRepository $er) {
                    return $er->createQueryBuilder('service')
                        ->where('service.NomService not Like :id')
                        ->setParameter('id','Administration')
                         ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Chambre::class,
        ]);
    }
}
