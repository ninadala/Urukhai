<?php

namespace App\Form;

use App\Entity\Franchise;
use App\Entity\Salle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\ChoiceList\ChoiceList;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
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
            ->add('email', EmailType::class, [
                "label" => "Email",
                "required" => true,
            ])
            ->add('password', TextType::class, [
                "label" => "Mot de passe",
                "required" => true
            ])
            ->add('adress', TextType::class, [
                "label" => "Adresse postale",
                "required" => true
            ])
            ->add('franchise_id', EntityType::class, [
                'class' => Franchise::class,
                'choice_label'=> 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_toekn_id' => 'post_item',
        ]);
    }
}
