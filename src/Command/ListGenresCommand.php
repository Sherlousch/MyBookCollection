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
    name: 'app:list-genres',
    description: 'Add a short description for your command',
)]
class ListGenresCommand extends Command
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

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $genres = $this->genreRepository->findAll();
        if(!$genres) {
            $output->writeln('<comment>no genres found<comment>');
            exit(1);
        }

        foreach($genres as $genre)
        {
            $output->writeln($genre->__toString());
        }

        return Command::SUCCESS;
    }
}
