<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
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
                "label" => "Nom d'utilisateur",
                "required" => true,
                "constraints" => [new NotBlank(["message" => "Le nom d'utilisateur ne peut pas être vide !"])]
            ])
            ->add('lastname', TextType::class, [
                "label" => "Nom",
                "required" =>true,
                "constraints" => [ new Length(
                    ["min" => 2, 
                    "max" => 180, 
                    "minMessage" => "Ce champ ne peut pas comporter moins de 2 caractères", 
                    "maxMessage" => "Ce champ ne peut pas comporter plus de 180 caractères !"]
                )]
            ])
            ->add('firstname', TextType::class, [
                "label" => "Prénom",
                "required" => true,
                "constraints" => [ new Length(
                    ["min" => 2, 
                    "max" => 180, 
                    "minMessage" => "Ce champ ne peut pas comporter moins de 2 caractères", 
                    "maxMessage" => "Ce champ ne peut pas comporter plus de 180 caractères !"]
                )]
            ])
            ->add('email', EmailType::class, [
                "label" => "Email",
                "required" => true,
                "constraints" => [ new Email(["message" => "Vous devez entrer un email valide"])]
            ])
            // ->add('roles', ChoiceType::class, [
            //     "label" => "Rôle",
            //     "required" => true,
            //     'choices' => [
            //         'Admin URUKHAI' => 'ROLE_ADMIN'(1),
            //         'Franchise' => 'ROLE_USER'(2),
            //         'Salle' => 'ROLE_USER'(2)
            //     ]
            // ])
            ->add('password', PasswordType::class, [
                "label" => "Mot de passe",
                "required" => true,
                "constraints" => [
                    new NotBlank(["message" => "Le mot de passe ne peut pas être vide !"])
                ]
            ])
        ;
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
