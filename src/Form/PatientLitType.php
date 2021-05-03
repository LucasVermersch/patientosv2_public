<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Lit;
use App\Entity\Patient;
use App\Repository\LitRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientLitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('Lit',EntityType::class,[
                'class' => Lit::class,
                'choice_label' => function(Lit $lit) {
                    return $lit->getChambre()->getService()->getNomService(). " - ".$lit->getChambre()->getId();
                },
                'query_builder' => function (LitRepository $er) use($options) {
                    return $er->createQueryBuilder('lit')
                        ->where('lit.Occupation = 0')
                        ->join('lit.Chambre','c')
                        ->join('c.Service','s')
                        ->andWhere('s.NomService = :nomService')
                        ->setParameter('nomService', $options['nomService'] );
                    },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired(array(
            'nomService'
        ));
        $resolver->setDefaults([
            'data_class' => Patient::class
        ]);
    }
}
