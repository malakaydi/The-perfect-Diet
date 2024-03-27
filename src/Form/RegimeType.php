<?php

namespace App\Form;
use App\Entity\Regime;
use App\Entity\Plat;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegimeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomregime')
            ->add('duree')
            ->add('type')
            
            
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter Regime', // Set the label explicitly
                'attr' => ['class' => 'btn btn-primary'], // Add Bootstrap classes if needed
            ])
            ;
          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Regime::class,
        ]);
    }
}
