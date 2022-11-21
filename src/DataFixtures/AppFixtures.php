<?php
 
namespace App\DataFixtures;
 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Membre;
use App\Repository\MembreRepository;
use App\Entity\Bookcollection;
use App\Repository\BookcollectionRepository;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Entity\Book;
use App\Repository\BookRepository;
use App\Entity\Bookcase;
use App\Repository\BookcaseRepository;

 
class AppFixtures extends Fixture
{
      /**
    * Generates initialization data for membres : [name]
    * @return \\Generator
    */
    private static function membreDataGenerator()
    {
        yield ["Lousch"];
        yield ["Club Jeux"];
    }

    /**
    * Generates initialization data for bookcollections : [description, membre_name]
    * @return \\Generator
    */
   private static function bookcollectionsDataGenerator()
   {
       yield ["Lousch's Collection", "Lousch"];
       yield ["CJ's Collection", "Club Jeux"];
   }
 
   /**
    * Generates initialization data for genres : [name, parent_name]
    * @return \\Generator
    */
    private static function genresDataGenerator()
    {
        yield ["Manga", null];
        yield ["Manhwa", null];
        yield ["Novel", null];
        yield ["Shonen", "Manga"];
        yield ["Shojo", "Manga"];
        yield ["Fantasy novel", "Novel"];
        yield ["Dective novel", "Novel"];
        yield ["Science Fiction novel", "Novel"];
        yield ["Dystopian novel", "Novel"];
        yield ["Horror novel", "Novel"];
    }

   /**
    * Generates initialization data for books:
    *  [title, author, genres_name, bookcollection_description]
    * @return \\Generator
    */
   private static function booksDataGenerator()
   {
       yield ["Solo Leveling T1", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T2", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T3", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T4", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T5", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T6", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T7", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Solo Leveling T8", "Chugong", ["Manhwa"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T1", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T2", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T3", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T4", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T5", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T6", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T7", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T8", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T9", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T10", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T11", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T12", "Hiromu Arakawa", ["Manga", "Shonen"], "Lousch's Collection"];
       yield ["The Hobbit", "J.R.R. Tolkien", ["Novel", "Fantasy novel"], "Lousch's Collection"];
       yield ["The Lord of the Rings T1", "J.R.R. Tolkien", ["Novel", "Fantasy novel"], "Lousch's Collection"];
       yield ["The Lord of the Rings T2", "J.R.R. Tolkien", ["Novel", "Fantasy novel"], "Lousch's Collection"];
       yield ["The Lord of the Rings T3", "J.R.R. Tolkien", ["Novel", "Fantasy novel"], "Lousch's Collection"];
       yield ["Les Chevaliers d'Emeraude T1", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T2", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T3", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T4", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T5", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T6", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T7", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T8", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T9", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T10", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T11", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
       yield ["Les Chevaliers d'Emeraude T12", "Anne Robillard", ["Novel", "Fantasy novel"], "CJ's Collection"];
   }

      /**
    * Generates initialization data for bookcases:
    *  [description, membre_name, released, books_title]
    * @return \\Generator
    */
    private static function bookcasesDataGenerator()
    {
        yield ["FMA Perfect", "Lousch", false, [
            "Fullmetal Alchemist perfect T1",
            "Fullmetal Alchemist perfect T2",
            "Fullmetal Alchemist perfect T3",
            "Fullmetal Alchemist perfect T4",
            "Fullmetal Alchemist perfect T5",
            "Fullmetal Alchemist perfect T6",
            "Fullmetal Alchemist perfect T7",
            "Fullmetal Alchemist perfect T8",
            "Fullmetal Alchemist perfect T9",
            "Fullmetal Alchemist perfect T10",
            "Fullmetal Alchemist perfect T11",
            "Fullmetal Alchemist perfect T12",
        ]];
        yield ["Solo Leveling", "Lousch", false, [
            "Solo Leveling T1",
            "Solo Leveling T2",
            "Solo Leveling T3",
            "Solo Leveling T4",
            "Solo Leveling T5",
            "Solo Leveling T6",
            "Solo Leveling T7",
            "Solo Leveling T8",
        ]];
        yield ["Middle-Earth Saga", "Lousch", true, [
            "The Hobbit",
            "The Lord of the Rings T1",
            "The Lord of the Rings T2",
            "The Lord of the Rings T3",
        ]];
        yield ["Les Chevaliers d'Emeraude", "Club Jeux", true, [
            "Les Chevaliers d'Emeraude T1",
            "Les Chevaliers d'Emeraude T2",
            "Les Chevaliers d'Emeraude T3",
            "Les Chevaliers d'Emeraude T4",
            "Les Chevaliers d'Emeraude T5",
            "Les Chevaliers d'Emeraude T6",
            "Les Chevaliers d'Emeraude T7",
            "Les Chevaliers d'Emeraude T8",
            "Les Chevaliers d'Emeraude T9",
            "Les Chevaliers d'Emeraude T10",
            "Les Chevaliers d'Emeraude T11",
            "Les Chevaliers d'Emeraude T12",
        ]];
    }
 
   public function load(ObjectManager $manager)
   {
        $membreRepo = $manager->getRepository(Membre::class);
        foreach (self::membreDataGenerator() as [$name] ) {
            $membre = new Membre();
            $membre->setName($name);
            $manager->persist($membre);         
        }
        $manager->flush();
        
        $bookcollectionRepo = $manager->getRepository(Bookcollection::class);
        foreach (self::bookcollectionsDataGenerator() as [$description, $membre_name] ) {
            $bookcollection = new Bookcollection();
            $bookcollection->setDescription($description);
            $membre = $membreRepo->findOneBy(['name' => $membre_name]);
            $bookcollection->setMembre($membre);
            $manager->persist($bookcollection);
            $manager->persist($membre);         
        }
        $manager->flush();

        $genreRepo = $manager->getRepository(Genre::class);

        foreach (self::genresDataGenerator() as [$name, $parent_name] ) {
            $genre = new Genre();
            $genre->setName($name);
            if ($parent_name !== null) {
                $parent = $genreRepo->findOneBy(['name' => $parent_name]);
                $genre->setParent($parent);
            }
            $manager->persist($genre);
            $manager->flush();         
        }
        
 
        foreach (self::booksDataGenerator() as [$title, $author, $genres_name, $bookcollection_description])
        {
            $bookcollection = $bookcollectionRepo->findOneBy(['description' => $bookcollection_description]);
            $book = new Book();
            $book->setCollection($bookcollection);
            $book->setTitle($title);
            $book->setAuthor($author);
            foreach ($genres_name as $genre_name)
            {
                $genre = $genreRepo->findOneBy(['name' => $genre_name]);
                $genre->addBook($book);
                $book->addGenre($genre);
                $manager->persist($genre);
                $manager->persist($book);
            }
            $bookcollection->addBook($book);
            // there's a cascade persist on bookcollection-books which avoids persisting down the relation
            $manager->persist($bookcollection);
        }
        $manager->flush();

        $bookRepo = $manager->getRepository(Book::class);
        foreach (self::bookcasesDataGenerator() as [$description, $membre_name, $released, $books_title])
        {
            $membre = $membreRepo->findOneBy(['name' => $membre_name]);
            $bookcase = new Bookcase();
            $bookcase->setMembre($membre);
            $bookcase->setDescription($description);
            $bookcase->setReleased($released);
            foreach ($books_title as $book_title)
            {
                $book = $bookRepo->findOneBy(['title' => $book_title]);
                $bookcase->addBook($book);
                $book->addBookcase($bookcase);
                $manager->persist($bookcase);
                $manager->persist($book);
            }
            $membre->addBookcase($bookcase);
            // there's a cascade persist on bookcollection-books which avoids persisting down the relation
            $manager->persist($membre);
        }
        $manager->flush();
    }
}