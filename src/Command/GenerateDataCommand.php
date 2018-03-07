<?php

namespace App\Command;

use App\Entity\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A command to generate test data
 *
 * @package App\Command
 */
class GenerateDataCommand extends Command
{
    /** @var EntityManagerInterface The entity manager */
    private $entityManager;

    /**
     * Creates the generate data command.
     *
     * @param null|string $name The name of the command; passing null means it must be set in configure().
     * @param EntityManagerInterface $entityManager The entity manager.
     */
    public function __construct(?string $name = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($name);

        $this->entityManager = $entityManager;
    }

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('cms:generate-data')
            ->setDescription('Generate test data for the system')
            ->addOption('--count', '-c', InputOption::VALUE_OPTIONAL, 'The number of content items to create', 100);
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input The command input interface.
     * @param OutputInterface $output The command output interface.
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        for ($i = 0; $i < $input->getOption('count'); $i++) {
            $content = new Content();
            $content->setTitle('Test title');
            $content->setContent('
Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint
occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
');

            $this->entityManager->persist($content);
        }

        $this->entityManager->flush();
    }
}