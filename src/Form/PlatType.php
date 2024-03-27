<?php

namespace App\Form;
use App\Entity\Regime;
use App\Entity\Plat;
use App\Entity\Image;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nomplat')
             
            ->add('cout')
            ->add('nbreCalories')
            ->add('ingredients')
            ->add('regime', EntityType::class,[
                'class'=> 'App\Entity\regime',
                'choice_label' => 'nomregime',
                'multiple' => false,
            ])
            ->add('image', EntityType::class, [
                'class' => Image::class,
                'choice_label' => 'url',
            ])
            
            ->add('save', SubmitType::class, [
                'label' => 'Ajouter Plat', // Set the label explicitly
                'attr' => ['class' => 'btn btn-primary'], // Add Bootstrap classes if needed
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    
        {
            $resolver->setDefaults([
                'data_class' => Plat::class,
            ]);
        }
    }
    
