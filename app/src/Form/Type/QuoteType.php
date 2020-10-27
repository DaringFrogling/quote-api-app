<?php

declare(strict_types = 1);

namespace App\Form\Type;

use App\Entity\Quote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;


class QuoteType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
          ->add('category_id', IntegerType::class,[
            'constraints' => [
                new NotNull()
            ]
        ])->add('author_id', IntegerType::class,[
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