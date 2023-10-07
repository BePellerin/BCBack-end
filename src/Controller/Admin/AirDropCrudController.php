<?php

namespace App\Controller\Admin;

use App\Entity\AirDrop;
use App\Form\AirDropType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\HttpFoundation\Request;

class AirDropCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return AirDrop::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
    // public function __invoke(Request $request, EntityManagerInterface $entityManager)
    // {
    //     $airDrop = new AirDrop();
    //     $airDrop->setPict($request->files->get('file'));
    // }
}
