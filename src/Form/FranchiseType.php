<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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
            ->add('user', EntityType::class, [
                'label' =>  "Administrateur",
                'class' => User::class,
                'choice_label'=> 'username'
            ])
            ->add("activated", CheckboxType::class, [
                "label" => "Active ?",
                "required" => false
            ])
            ->add('permissions', EntityType::class, [
                'label' => 'Permissions',
                'class' => Permission::class,
                'choice_label' => 'name',
                'expanded'=> true,
                'multiple' => true
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