<?php
/**
 * File
 *
 * User: kreemer <kreemer@me.com>
 * File: MathImporterCommandTest.php
 * Date: 10.12.13
 * Time: 14:45
 */

namespace DMS\SystemBundle\Tests\Command;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use DMS\SystemBundle\Command\MathImporterCommand;

class MathImporterCommandTest extends WebTestCase
{
    /**
     * @test
     * @expectedException \RuntimeException
     * @return void
     */
    public function needArguments()
    {
        $application = new Application();
        $application->add(new MathImporterCommand());

        $command = $application->find('dms:import');
        $commandTester = new CommandTester($command);

        $commandTester->execute(array('command' => $command->getName()));
    }
}
