<?php

namespace App\Controller\Admin;

use App\Entity\Nft;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class NftCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Nft::class;
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
