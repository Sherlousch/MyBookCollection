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
    name: 'app:list-bookcollections',
    description: 'Add a short description for your command',
)]
class ListBookcollectionsCommand extends Command
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

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bookcollections = $this->bookcollectionRepository->findAll();
        if(!$bookcollections) {
            $output->writeln('<comment>no bookcollections found<comment>');
            exit(1);
        }

        foreach($bookcollections as $bookcollection)
        {
            $output->writeln($bookcollection->__toString());
        }

        return Command::SUCCESS;
    }
}
