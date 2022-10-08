<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Entity\Salle;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "label" => "Nom",
                "required" => true,
                "constraints" => [new Length(["min" => 3, "max" => 60, "minMessage" => "Le champ nom ne peut pas contenir moins de 3 caractères", "maxMessage" => "Le champ nom ne peut pas contenir plus de 60 caractères"])]
            ])
            ->add('address', TextType::class, [
                "label" => "Adresse postale",
                "required" => true
            ])
            ->add('capacity', IntegerType::class, [
                "label" => "Capacité de la salle",
                "required" => true
            ])
            ->add('franchise', EntityType::class, [
                'class' => Franchise::class,
                'choice_label'=> 'name',
                'disabled' => true
            ])
            ->add('user', EntityType::class, [
                'label' => 'Administrateur',
                'class' => User::class,
                'choice_label'=> 'username'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id' => 'post_item',
        ]);
    }
}
