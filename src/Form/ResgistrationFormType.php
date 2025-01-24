<?php
namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Email;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Correo electrónico',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingresa tu correo electrónico.',
                    ]),
                    new Email([
                        'message' => 'Por favor, ingresa un correo válido.',
                    ]),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Contraseña',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Por favor, ingresa una contraseña.',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'La contraseña debe tener al menos {{ limit }} caracteres.',
                            // Puedes definir un máximo opcional si quieres
                        ]),
                    ],
                ],
                'second_options' => [
                    'label' => 'Repite la contraseña',
                ],
                'invalid_message' => 'Las contraseñas deben coincidir.',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Registrarse',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Asocia este formulario con la entidad User
        ]);
    }
}
