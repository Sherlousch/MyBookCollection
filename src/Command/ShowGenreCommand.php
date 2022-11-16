<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Genre;
use App\Repository\GenreRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'app:show-genre',
    description: 'Add a short description for your command',
)]
class ShowGenreCommand extends Command
{
    /**
     * @var GenreRepository
     */
    private $genreRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->genreRepository = $container->get('doctrine')->getManager()->getRepository(Genre::class);
    }

    protected function configure()
    {
        $this
            //->setName('Show parent and sub genres of a genre')           
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the genre')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');

        $genre = $this->genreRepository->findOneBy(
            ['name' => $name]);
        if(!$genre) 
        {
            $output->writeln('unknown genre: ' . $name . '');
            exit(1);
        }
        $output->writeln($genre . ':');

        //Show parents
        $parent = $genre->getParent();
        if(!$parent)
        {
            $output->writeln('no parent');
        }
        else
        {
            $output->writeln('parent: ' . $parent);
        }

        //Show subgenres
        if($genre->getSubgenres())
        {
            $output->writeln('no subgenres');
        }
        else
        {
            $output->writeln('Subgenres:');
            foreach($genre->getSubgenres() as $subgenre) 
            {
                $output->writeln('-'. $subgenre);
            }
        }

        return Command::SUCCESS;
    }
}
