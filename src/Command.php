<?php

namespace Simondubois\LearningCardEditor;

use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Command extends BaseCommand
{
    private $parser;

    protected function configure()
    {
        $this
            ->setName('learningcard-editor')
            ->setDescription('Edit cards to learn language, dates, etc.')
            ->setHelp("CLI to edit cards to learn language, dates, etc.")
            ->addArgument('input', InputArgument::REQUIRED, 'Path to the file providing card descriptions.');
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);

        $this->parser = new Parser;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Parse input...');
        var_dump($this->parser->parse($input->getArgument('input')));
    }
}
