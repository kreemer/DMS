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
            ->addOption('dry-run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        $dryrun = $input->getOption('dry-run');
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
        $keywords = Lexer::run($lines);
        var_dump($keywords);
        $tasks = Parser::run($keywords);
        var_dump($tasks);


        /*        $parser = new Parser();
                try {
                    $tasks = $parser->parseContent($content);
                } catch(Parser\Exception $e) {
                    throw new \Exception('Parse Exception: ' . $e->getMessage() . ' (' . $e->getCode() . '/' . $e->getLine() . ')');
                }


                $em = $this->getContainer()->get('doctrine')->getManager();
                $equation = new Equation();
                $equation->setFile($path);
                !$dryrun ? $em->persist($equation) : null;
                foreach ($tasks as $task) {
                    $task->setEquation($equation);

                    !$dryrun ? $em->persist($task) : null;
                }
                !$dryrun ? $em->flush() : null;*/
        $output->writeln('<info>Import was successfully</info>');
    }
}