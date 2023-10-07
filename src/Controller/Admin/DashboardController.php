<?php

namespace App\Controller\Admin;

// use App\Controller\UserController;

use App\Entity\AirDrop;
use App\Entity\Category;
use App\Entity\Collecs;
use App\Entity\History;
use App\Entity\Nft;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration ViperCo');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Collections', 'fas fa-grip-horizontal', Collecs::class);
        yield MenuItem::linkToCrud('Nfts', 'fas fa-image', Nft::class);
        yield MenuItem::linkToCrud('AirDrops', 'fas fa-rocket', AirDrop::class);
        yield MenuItem::linkToCrud('Categories', 'fas fa-boxes', Category::class);
        yield MenuItem::linkToCrud('Historique', 'fas fa-archive', History::class);
    }
}
