<?php

namespace App\Command;



use App\Repository\CsvRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RosterActivityPrinter
{
    protected static $defaultName = 'app:roster-activity-printer';
    private const EXAMPLE_CSV = 'roster.HTML';

    private CsvRepository $csvRepository;

    public function __construct(CsvRepository $csvRepository)
    {
        $this->csvRepository = $csvRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Display content of html to console');
        $this
            ->addOption('file', null, InputOption::VALUE_OPTIONAL, 'File', self::EXAMPLE_CSV)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $csvFile = sprintf('csv/%s', $input->getOption('file'));
        $csvContent = $this->csvRepository->getCsvContent($csvFile);
        if (null === $csvContent) {
            $output->writeln('File does not exist.');

            return Command::FAILURE;
        }

        $table = new Table($output);
        $table
            ->setHeaders($csvContent->getHeader())
            ->setRows($csvContent->getRows())
        ;
        $table->render();

        return Command::SUCCESS;
    }
}