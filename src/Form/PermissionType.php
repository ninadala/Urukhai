<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Entity\Salle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class PermissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
                "required" => true,
                "constraints" => [new NotBlank(["message" => "Le nom de la permission ne peut pas être vide !"])]
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                "required" =>true,
                "constraints" => [ new Length(
                    ["min" => 2, 
                    "max" => 255, 
                    "minMessage" => "Ce champ ne peut pas comporter moins de 2 caractères", 
                    "maxMessage" => "Ce champ ne peut pas comporter plus de 255 caractères !"]
                )]
            ])
            ->add('franchise', EntityType::class, [
                'label' => 'Franchise',
                'class' => Franchise::class,
                'choice_label'=> 'name',
                'expanded' => true,
                'multiple' => true
            ])
            ->add('salle', EntityType::class, [
                'label' => 'Salles',
                'class' => Salle::class,
                'choice_label'=> 'name',
                'expanded' => true,
                'multiple' => true
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Permission::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',

        ]);
    }
}
