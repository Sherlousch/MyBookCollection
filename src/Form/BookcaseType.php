<?php

namespace App\Form;

use App\Entity\Bookcase;
use App\Entity\Membre;
use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookcaseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        dump($options);
        $bookcase = $options['data'] ?? null;
        $membre = $bookcase->getMembre();
        $bookcollection = $membre->getBookcollection();
        $books = $bookcollection->getBooks();
        $builder
            ->add('description')
            ->add('released')
            ->add('membre', null, ['disabled'   => true,])
            ->add('books')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Bookcase::class,
        ]);
    }
}
