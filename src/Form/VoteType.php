<?php

namespace App\Form;

use App\Entity\Equipe;
use App\Entity\Rencontre;
use App\Entity\Vote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('point')
            ->add('vote', EntityType::class, [
                'class' => Equipe::class,
                'choice_label' => 'id',
            ])
            ->add('rencontre', EntityType::class, [
                'class' => Rencontre::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vote::class,
        ]);
    }
}
