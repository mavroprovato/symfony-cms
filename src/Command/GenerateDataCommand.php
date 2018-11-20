<?php

namespace App\Command;

use App\Entity\Category;
use App\Entity\Post;
use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * A command to generate test data
 *
 * @package App\Command
 */
class GenerateDataCommand extends ContainerAwareCommand
{

    /**
     * Configure the command.
     */
    protected function configure()
    {
        $this
            ->setName('cms:generate-data')
            ->setDescription('Generate test data for the system')
            ->addOption('--count', '-c', InputOption::VALUE_OPTIONAL, 'The number of content items to create', 100)
            ->addOption('--start-date', null, InputOption::VALUE_OPTIONAL,
                'The minimum publication date for the generated items')
            ->addOption('--end-date', null, InputOption::VALUE_OPTIONAL,
                'The maximum publication date for the generated items');
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
        // Parse the count option
        if (intval($input->getOption('count')) == 0) {
            $io->error("Count should be a positive integer");
            return 1;
        }

        // Parse the start date option
        if ($input->getOption('start-date')) {
            $startDate = \DateTime::createFromFormat('Y-m-d', $input->getOption('start-date'));
            if (!$startDate) {
                $io->error("Start date format is not valid (YYYY-MM-DD)");
                return 1;
            }
        } else {
            $startDate = new \DateTime();
            $startDate->modify('-1 year');
        }

        // Parse the end date option
        if ($input->getOption('end-date')) {
            $endDate = \DateTime::createFromFormat('Y-m-d', $input->getOption('end-date'));
            if (!$startDate) {
                $io->error("End date format is not valid (YYYY-MM-DD)");
                return 1;
            }
        } else {
            $endDate = new \DateTime();
        }

        if ($startDate >= $endDate) {
            $io->error("Start date must be before end date.");
            return 1;
        }

        // Generate the content
        $categories = $entityManager->getRepository(Category::class)->findAll();
        $tags = $entityManager->getRepository(Tag::class)->findAll();
        for ($i = 0; $i < $input->getOption('count'); $i++) {
            // Set post basic data
            $post = new Post();
            $post->setTitle('Test Title');
            $post->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor
incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut
aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat
nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
laborum.');
            $post->setPublishedAt($this->randomDateTime($startDate, $endDate));
            // Set post tags
            $postTags = array_rand(array_values($tags), min(3, count($tags)));
            foreach ($postTags as $tagIndex) {
                $post->getTags()->add($tags[$tagIndex]);
            }
            // Set post categories
            $postCategories = array_rand($categories, min(3, count($categories)));
            foreach ($postCategories as $categoryIndex) {
                $post->getCategories()->add($categories[$categoryIndex]);
            }

            $entityManager->persist($post);
        }
        $entityManager->flush();

        $io->writeln("Successfully generated {$input->getOption('count')} content items.");

        return 0;
    }

    /**
     * Return a random date between two dates.
     *
     * @param \DateTime $startDate The minimum date.
     * @param \DateTime $endDate The maximum date.
     * @return \DateTime The random date.
     */
    private function randomDateTime(\DateTime $startDate, \DateTime $endDate): \DateTime
    {
        $randomTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());
        $randomDate = new \DateTime();
        $randomDate->setTimestamp($randomTimestamp);

        return $randomDate;
    }
}