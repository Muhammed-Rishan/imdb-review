<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Entity\Rating;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
//    #[IsGranted("ROLE_ADMIN")]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('IMdb');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::linkToCrud('Movies', 'fas fa-film', Movie::class)
            ->setController(MovieCrudController::class)
            ->setAction(Crud::PAGE_INDEX);

        yield MenuItem::linkToCrud('Comments', 'fas fa-comment', Comment::class)
            ->setController(CommentCrudController::class)
            ->setAction(Crud::PAGE_INDEX);

        yield MenuItem::linkToCrud('Ratings', 'fas fa-star', Rating::class)
            ->setController(RatingCrudController::class)
            ->setAction(Crud::PAGE_INDEX);

        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class)
            ->setController(UserCrudController::class)
            ->setAction(Crud::PAGE_INDEX);
    }

}
