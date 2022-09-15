<?php

namespace App\Form;

use App\Entity\Franchise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class FranchiseType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("name", TextType::class, [
                "label" => "Nom",
                "required" => true,
                "constraints" => [new Length(["min" => 5, "max" => 60, "minMessage" => "Le champ nom ne peut pas être vide", "maxMessage" => "Le champ nom ne peut pas faire plus de 60 caractères"])]
            ])
            ->add("email", EmailType::class,[
                "label" => "Email",
                "required" => true,
                "constraints" => [new Length(["min" => 5, "max" => 255, "minMessage" => "Le champ email ne peut pas être vide", "maxMessage" => "Le champ email ne peut pas faire plus de 255 caractères"])]
            ])
            ->add("password", TextType::class, [
                "label" => "Mot de passe Test",
                "required" => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            "data_class" => Franchise::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',
        ]);
    }
}