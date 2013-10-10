<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: MathImporterCommand.php
 * Date: 01.09.13
 * Time: 11:56
 */

namespace DMS\SystemBundle\Command;

use DMS\SystemBundle\Entity\Equation;
use DMS\SystemBundle\Lexer;
use DMS\SystemBundle\Parser;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MathImporterCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('dms:import')
            ->setDescription('Import a file with math instructions')
            ->addArgument(
                'path',
                InputArgument::REQUIRED,
                'path to the file which will be imported'
            )
            ->addArgument(
                'name',
                InputArgument::OPTIONAL,
                'give the imported mathematical equation a name'
            )
            ->addOption('dry-run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $dryrun = $input->getOption('dry-run');
        $name = $input->getArgument('name') ?: $path;

        if (!file_exists($path)) {
            throw new \Exception('File not there');
        }
        if ($input->getOption('verbose') && $dryrun) {
            $output->writeln('the option dryrun was given. File will be only parsed, not saved!');
        }
        if ($input->getOption('verbose')) {
            $output->writeln('start import of "' . $path . '"');
        }

        $content = file_get_contents($path);
        $lines = explode(PHP_EOL, $content);
        try {
            $keywords = Lexer::run($lines);
            $tasks = Parser::run($keywords);
        } catch(Parser\Exception $e) {
            $output->writeln('<error>there was an error while parsing :(</error>');
            $output->writeln('<error>' . $e->getMessage() . ' (' . $e->getFile() . ':' . $e->getLine() . ')</error>');
            if ($input->getOption('verbose')) {
                $output->writeln($e->getTraceAsString());
            }
            return;
        }

        if (count($tasks) == 0) {
            $output->writeln('<error>No exception happend, but the parser couldnt find a single task!</error>');
            return;
        }

        foreach ($tasks as $key => $task) {
            if ($input->getOption('verbose')) {
                $output->writeln('<info>Task ' . $key . ':[' . $task->getMath() . ']</info>');
            }
        }

        $em = $this->getContainer()->get('doctrine')->getManager();
        $equation = new Equation();
        $equation->setFile($path);
        $equation->setTitle($name);
        !$dryrun ? $em->persist($equation) : null;
        foreach ($tasks as $task) {
            $task->setEquation($equation);
            !$dryrun ? $em->persist($task) : null;
        }
        !$dryrun ? $em->flush() : null;

        if ($input->getOption('verbose') && !$dryrun) {
            $output->writeln('<info>Imported ' . count($tasks) . ' tasks</info>');
        }
        if (!$dryrun) {
            $output->writeln('<info>Import was successfully</info>');
        } else {
            $output->writeln('<info>Parser couldn`t find any problems</info>');
        }
    }
}