<?php

namespace App\Form;

use App\Entity\Chambre;
use App\Entity\Lit;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('EtatDuLit')
            ->add('Occupation')
            ->add('Chambre',EntityType::class,[
                'class' => Chambre::class,
                'choice_label' => function(Chambre $chambre) {
                    return $chambre->getService()->getNomService(). " - ".$chambre->getId();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lit::class,
        ]);
    }
}
