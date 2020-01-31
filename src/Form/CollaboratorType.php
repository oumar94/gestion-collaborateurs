<?php

namespace App\Form;

use App\Entity\ActualStatus;
use App\Entity\Collaborator;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollaboratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('date_dispo')
            ->add('date_depart_prevue')
            ->add('imageFile',FileType::class,[
                'required'=>false
            ])
            ->add('actualStatus',EntityType::class,[
                'required'=>true,
                'label'=>'statut actuel',
                'class'=>ActualStatus::class,
                'choice_label'=>'name',
                'multiple'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Collaborator::class,
        ]);
    }
}
