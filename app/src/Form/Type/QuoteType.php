<?php

declare(strict_types = 1);

namespace App\Form\Type;

use App\Entity\Category;
use App\Entity\Quote;
use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;


class QuoteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
          ->add('category', EntityType::class,[
            'class' => Category::class,
            'constraints' => [
                new NotNull()
            ]
        ])->add('author', EntityType::class,[
            'class' => Author::class,
            'constraints' => [
                new NotNull()
            ]
        ])->add('text', TextType::class,[
            'constraints' => [
                new NotNull(),
                new Length([
                    'max' => 250
                ])
            ]
        ]);
    }

    public function configureOptions(OptionsResolver $resolver) : void 
    {
        $resolver->setDefaults([
            'data_class' => Quote::class,
        ]);
    }

}