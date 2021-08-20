<?php

namespace App\Command;

use App\Services\RosterService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class RosterActivityToJsonCommand extends Command
{
    protected static $defaultName = 'app:roster-activity-printer';
    private const EXAMPLE_HTML = 'roster.HTML';

    private RosterService $rosterService;
    private Serializer $serializer;

    public function __construct(RosterService $rosterService)
    {
        $this->rosterService = $rosterService;
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Display content of html to console');
        $this
            ->addOption('file', null, InputOption::VALUE_OPTIONAL, 'File', self::EXAMPLE_HTML)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $htmlFile = sprintf('assets/%s', $input->getOption('file'));

        $roster = $this->rosterService->getHtmlContentToRosterDays($htmlFile);
        if (null === $roster) {
            $output->writeln('File does not exist.');

            return Command::FAILURE;
        }

        $output->writeln($this->serializer->serialize($roster, 'json'));

        return Command::SUCCESS;
    }
}
