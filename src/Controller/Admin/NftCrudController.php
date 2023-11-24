<?php

namespace App\Controller\Admin;

use App\Entity\Nft;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class NftCrudController extends AbstractCrudController
{
    use Trait\adminTrait;
    public static function getEntityFqcn(): string
    {
        return Nft::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),

        ];
    }
}
