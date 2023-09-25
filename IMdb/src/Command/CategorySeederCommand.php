<?php

// src/Command/CategorySeederCommand.php

namespace App\Command;

use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CategorySeederCommand extends Command
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        parent::__construct();

        $this->doctrine = $doctrine;
    }

    protected function configure()
    {
        $this
            ->setName('app:seed-categories')
            ->setDescription('Seed categories into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->doctrine->getManager();

        $categories = [
            'action',
            'adventure',
            'comedy',
            'drama',
            'fantasy',
            'horror',
            'musicals',
            'mystery',
            'romance',
            'science fiction',
            'sports',
            'thriller',
            'Western',
        ];

        foreach ($categories as $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $entityManager->persist($category);
        }

        $entityManager->flush();

        $output->writeln('Categories seeded successfully.');

        return 0;
    }
}
