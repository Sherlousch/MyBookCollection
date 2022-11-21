<?php

namespace App\Form;

use App\Entity\Bookcase;
use App\Entity\Membre;
use App\Repository\BookRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookcaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        dump($options);
        $bookcase = $options['data'] ?? null;
        $membre = $bookcase->getMembre();
        $builder
            ->add('description')
            ->add('released')
            ->add('membre', null, ['disabled'   => true,])
            ->add('books', null, [
                'query_builder' => function (BookRepository $er) use ($membre) {
                    return $er->createQueryBuilder('bookcase')
                    ->leftJoin('bookcase.collection', 'bookcollection')
                    ->andWhere('bookcollection.membre = :membre')
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
