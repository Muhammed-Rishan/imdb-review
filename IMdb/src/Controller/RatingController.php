<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RatingController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function submitRating(Request $request, Movie $movie): Response
    {

        $user = $this->getUser();
        $username = $user->getUsername();

        $userRating = $request->request->get('rating');

        $rating = new Rating();
        $rating->setUser($user);
        $rating->setMovie($movie);
        $rating->setRating($userRating);

        $this->entityManager->persist($rating);
        $this->entityManager->flush();



        return $this->redirectToRoute('movie_detail', ['id' => $movie->getId()]);
    }
}