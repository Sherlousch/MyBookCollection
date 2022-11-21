<?php

namespace App\Form;

use App\Entity\Bookcase;
use App\Entity\Membre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookcaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('description')
            ->add('released')
            ->add('membre', null, ['disabled'   => true,])
            ->add('books', null, [
                'query_builder' => function (BookRepository $er) use ($membre) {
                    return $er->createQueryBuilder('g')
                    ->leftJoin('g.bookcollection', 'i')
                    ->andWhere('i.membre = :membre')
                    ->setParameter('membre', $membre)
                ;}
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bookcase::class,
        ]);
    }
}
