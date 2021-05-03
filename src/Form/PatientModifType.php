<?php

namespace App\Form;

use App\Entity\Patient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PatientModifType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Age')
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
            ->add('Telephone')
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Patient::class,
        ]);
    }
}
