<?php

namespace App\Form;

use App\Entity\ActualStatus;
use App\Entity\Client;
use App\Entity\Collaborator;
use App\Entity\OperatingMode;
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
            ->add('date_affectation')
            ->add('date_dispo')
            ->add('date_depart_prevue')
            ->add('remplacant_prevu')
            ->add('imageFile',FileType::class,[
                'required'=>false,
                'label'=>'photo de profile'
            ])
            ->add('actualStatus',EntityType::class,[
                'required'=>true,
                'label'=>'statut actuel',
                'class'=>ActualStatus::class,
                'choice_label'=>'name',
                'multiple'=>false
            ])
            ->add('operating_mode',EntityType::class,[
                'required'=>false,
                'label'=>'Mode de travail',
                'class'=>OperatingMode::class,
                'choice_label'=>'name',
                'multiple'=>false
            ])
            ->add('clients',EntityType::class,[
                'required'=>true,
                'label'=>'Les clients',
                'class'=>Client::class,
                'choice_label'=>'name',
                'multiple'=>true
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
