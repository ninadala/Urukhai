<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                "label"          => "Nom d'utilisateur",
                "required"       => true,
                "constraints"    => [new NotBlank(["message" => "Le nom d'utilisateur ne peut pas être vide !"])]
            ])
            ->add('lastname', TextType::class, [
                "label"          => "Nom",
                "required"       => true,
                "constraints"    => [ new Length(
                    ["min"       => 2, 
                    "max"        => 180, 
                    "minMessage" => "Ce champ ne peut pas comporter moins de 2 caractères", 
                    "maxMessage" => "Ce champ ne peut pas comporter plus de 180 caractères !"]
                )]
            ])
            ->add('firstname', TextType::class, [
                "label"          => "Prénom",
                "required"       => true,
                "constraints"    => [ new Length(
                    ["min"       => 2, 
                    "max"        => 180, 
                    "minMessage" => "Ce champ ne peut pas comporter moins de 2 caractères", 
                    "maxMessage" => "Ce champ ne peut pas comporter plus de 180 caractères !"]
                )]
            ])
            ->add('email', EmailType::class, [
                "label"          => "Email",
                "required"       => true,
                "constraints"    => [ new Email(["message" => "Vous devez entrer un email valide"])]
            ])
            ->add('roles', ChoiceType::class, [
                'label'          => 'Rôles',
                'required'       => true,
                'expanded'       => false,
                'multiple'       => false,
                'choices'        => [
                    'Admin URUKHAI' => 'ROLE_ADMIN',
                    'Client'        => 'ROLE_USER'
                ]
            ])
            ->add('password', PasswordType::class, [
                "label"          => "Mot de passe",
                "required"       => true,
                "constraints"    => [
                    new Length([
                    "min"        => 10,
                    "minMessage" => "Votre mot de passe doit contenir au moins 14 caractères"
                    ]),
                    new NotBlank([
                        "message" => "Le mot de passe ne peut pas être vide !"])
                ]
            ])
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                     // transform the array to a string
                     return count($rolesArray)? $rolesArray[0]: null;
                },
                function ($rolesString) {
                     // transform the string back to an array
                     return [$rolesString];
                }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',

        ]);
    }
}
