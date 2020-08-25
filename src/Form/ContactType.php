<?php

/**
 * (c) Adrien PIERRARD
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class ContactType.
 */
class ContactType extends AbstractType
{
    /**
     * Build a Contact form.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'constraints' =>
                        [
                            new NotBlank(),
                            new Length(['min' => 3, 'max' => 30]),
                        ],
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'constraints' =>
                        [
                            new NotBlank(),
                            new Length(['min' => 3, 'max' => 30]),
                        ],
                ]
            )
            ->add(
                'subject',
                TextType::class,
                [
                    'constraints' =>
                        [
                            new NotBlank(),
                            new Length(['min' => 3, 'max' => 60]),
                        ],
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'constraints' =>
                        [
                            new NotBlank(),
                            new Email(),
                        ],
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'constraints' =>
                        [
                            new NotBlank(),
                            new Length(['min' => 10]),
                        ],
                ]
            )
        ;
    }
}
