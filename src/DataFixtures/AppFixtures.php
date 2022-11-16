<?php
 
namespace App\DataFixtures;
 
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Bookcollection;
use App\Repository\BookcollectionRepository;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use App\Entity\Book;
 
class AppFixtures extends Fixture
{
   /**
    * Generates initialization data for bookcollections : [description]
    * @return \\Generator
    */
   private static function bookcollectionsDataGenerator()
   {
       yield ["Lousch's Collection"];
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
   }
 
   public function load(ObjectManager $manager)
   {
       $bookcollectionRepo = $manager->getRepository(Bookcollection::class);
 
       foreach (self::bookcollectionsDataGenerator() as [$description] ) {
           $bookcollection = new Bookcollection();
           $bookcollection->setDescription($description);
           $manager->persist($bookcollection);         
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
   }
}