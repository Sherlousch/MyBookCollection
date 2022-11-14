<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Entity\Bookcollection;
use App\Repository\BookcollectionRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;

#[AsCommand(
    name: 'app:show-bookcollection',
    description: 'Add a short description for your command',
)]
class ShowBookcollectionCommand extends Command
{
    /**
     * @var BookcollectionRepository
     */
    private $bookcollectionRepository;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();
        $this->bookcollectionRepository = $container->get('doctrine')->getManager()->getRepository(Bookcollection::class);
    }

    protected function configure()
    {
        $this
            //->setDescription('Show books of a bookcollection')           
            ->addArgument('description', InputArgument::REQUIRED, 'Description of the bookcollection')
        ;
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $description = $input->getArgument('description');

        $bookcollection = $this->bookcollectionRepository->findOneBy(
            ['description' => $description]);
        if(!$bookcollection) 
        {
            $output->writeln('unknown bookcollection: ' . $description . '');
            exit(1);
        }
        $output->writeln($bookcollection . ':');

        foreach($bookcollection->getBooks() as $book) 
        {
            $output->writeln('-'. $book);
        }

        return Command::SUCCESS;
    }
}
