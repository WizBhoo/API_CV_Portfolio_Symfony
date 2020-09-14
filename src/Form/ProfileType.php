<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ProfileType.
 */
class ProfileType extends AbstractType
{
    /**
     * Build a form to update User's profile.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class)
            ->add('lastname', TextType::class)
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Both passwords must match',
                    'required' => false,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' =>
                        [
                            'label' => 'Confirm Password',
                        ],
                ]
            )
        ;
    }

    /**
     * Set the default entity class link to this form type.
     *
     * @param OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(
            [
                'data_class' => User::class,
                'validation_groups' => ['profile'],
            ]
        );
    }
}
