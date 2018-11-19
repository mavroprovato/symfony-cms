<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A command to generate taxonomy.
 *
 * @package App\Command
 */
class GenerateTaxonomyCommand extends ContainerAwareCommand
{

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('cms:generate-taxonomy')
            ->setDescription('Generate test taxonomy data for the system');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input The command input interface.
     * @param OutputInterface $output The command output interface.
     * @return int
     * @throws \Doctrine\ORM\ORMException
     */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $io = new SymfonyStyle($input, $output);
        $entityManager = $this->getContainer()->get('doctrine')->getEntityManager();

        for ($i = 1; $i <= 5; $i++) {
            $tag = new Tag();
            $tag->setName('Tag ' . $i);
            $tag->setDescription('Tag ' . $i);

            $entityManager->persist($tag);
        }
        $entityManager->flush();
        $io->writeln('Tags generated');

        for ($i = 1; $i <= 5; $i++) {
            $category = new Category();
            $category->setName('Category ' . $i);
            $category->setDescription('Category ' . $i);

            $entityManager->persist($category);
        }
        $entityManager->flush();
        $io->writeln('Categories generated');

        return 0;
    }
}
