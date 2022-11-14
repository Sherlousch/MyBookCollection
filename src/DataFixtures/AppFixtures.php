<?php
 
namespace App\DataFixtures;
 
use App\Entity\Bookcollection;
use App\Repository\BookcollectionRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
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
    * Generates initialization data for books:
    *  [title, author, type, bookcollection_description]
    * @return \\Generator
    */
   private static function booksGenerator()
   {
       yield ["Solo Leveling T1", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T2", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T3", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T4", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T5", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T6", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T7", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Solo Leveling T8", "Chugong", "Manhwa", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T1", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T2", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T3", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T4", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T5", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T6", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T7", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T8", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T9", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T10", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T11", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
       yield ["Fullmetal Alchemist perfect T12", "Hiromu Arakawa", "Manga", "Lousch's Collection"];
 
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
 
       foreach (self::booksGenerator() as [$title, $author, $type, $bookcollection_description])
       {
           $bookcollection = $bookcollectionRepo->findOneBy(['description' => $bookcollection_description]);
           $book = new Book();
           $book->setCollection($bookcollection);
           $book->setTitle($title);
           $book->setAuthor($author);
           $book->setType($type);
           $bookcollection->addBook($book);
           // there's a cascade persist on bookcollection-books which avoids persisting down the relation
           $manager->persist($bookcollection);
       }
       $manager->flush();
   }
}