<?php

namespace App\Controller\Admin;

use App\Entity\AirDrop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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
}
