<?php

namespace App\Controller;


use App\DTO\CommentRatingData;
use App\Entity\Comment;
use App\Entity\Movie;
use App\Entity\Rating;
use App\Form\CommentRatingFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class MovieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/movies', name: 'movie_list')]
    public function listMovies(): Response
    {
        $movies = $this->entityManager->getRepository(Movie::class)->findAll();

        return $this->render('movie/list.html.twig', [
            'movies' => $movies,
        ]);
    }

    #[Route('/movie/{id}', name: 'movie_detail')]
    public function showMovieDetail(Request $request, Movie $movie): Response
    {
        $commentRatingData = new CommentRatingData();
        $form = $this->createForm(CommentRatingFormType::class, $commentRatingData);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $comment = new Comment();
            $comment->setUser($this->getUser());
            $comment->setMovie($movie);
            $comment->setComment($commentRatingData->getComment());


            $rating = new Rating();
            $rating->setUser($this->getUser());
            $rating->setMovie($movie);
            $rating->setRating($commentRatingData->getRating());


            $entityManager = $this->entityManager;
            $entityManager->persist($comment);
            $entityManager->persist($rating);
            $entityManager->flush();


        }


        $comments = $movie->getComments();
        $ratings = $movie->getRatings();

        return $this->render('movie/detail.html.twig', [
            'movie' => $movie,
            'form' => $form->createView(),
            'comments' => $comments,
            'ratings' => $ratings,
        ]);
    }

    #[Route('/user_review', name: 'user_review')]
    public function showUserReviews(): Response
    {

        $comments = $this->entityManager->getRepository(Comment::class)->findAll();
        $ratings = $this->entityManager->getRepository(Rating::class)->findAll();


        return $this->render('movie/review.html.twig', [
            'comments' => $comments,
            'ratings' => $ratings,
        ]);
    }
}

