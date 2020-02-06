<?php

namespace App\Form;

use App\Entity\ActualStatus;
use App\Entity\Client;
use App\Entity\CollaboratorSearch;
use App\Entity\OperatingMode;
use App\Entity\Options;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollaboratorSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('actualStatus',EntityType::class,[
                'required'=>false,
                'label'=>'Statut actuel',
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
                'required'=>false,
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
            'data_class' => CollaboratorSearch::class,
            'method'=>'get',
            'csrf_protection'=>false
        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
}
