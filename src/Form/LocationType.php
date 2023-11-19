<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'label' => 'Miasto',
                'attr' => [
                    'placeholder' => 'Wpisz miasto',
                ],
            ])
            ->add('country', CountryType::class, [
                'label' => 'Kraj',
                'placeholder' => 'Wybierz kraj',

            ])
            ->add('latitude', null, [
                'label' => 'Szerokość geograficzna',
                'attr' => [
                    'placeholder' => 'Wpisz szerokość geograficzną',
                ],
            ])
            ->add('longitude', null, [
                'label' => 'Długość geograficzna',
                'attr' => [
                    'placeholder' => 'Wpisz długość geograficzną',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }


}
