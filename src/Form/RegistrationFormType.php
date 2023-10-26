<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Email',
                    'style' => 'background: #8d3f7e; color: white'
                ],
            ])
            ->add('userName', TextType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Nom',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
            ])
            ->add('userFirstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Prénom',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
            ])
            ->add('userAdress', TextType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Votre adresse',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
            ])
            ->add('userCity', TextType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Ville',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
            ])
            ->add('userPC', TextType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Code postal',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
            ])
            ->add('userPhone', TextType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'placeholder' => 'Numéro de téléphone',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
            ])
            ->add('userType', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control place-color',
                    'style' => 'background: #8d3f7e; color: white;'
                ],
                'label' => 'Vous êtes : ',
                'choices' => [
                    'Particulier' => 1,
                    'Professionnel' => 2,
                ]
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter avant de vous inscrire',
                    ]),
                ],
                'label' => "En m'inscrivant à ce site j'accepte... "
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class' => 'form-control place-color',
                    'placeholder' => 'Mot de passe',
                    'style' => 'background: #8d3f7e; color: white; font-family'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
