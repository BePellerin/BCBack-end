<?php

namespace App\Controller\Admin;

use App\Entity\Collecs;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;

class CollecsCrudController extends AbstractCrudController
{
    use Trait\adminTrait;
    public static function getEntityFqcn(): string
    {
        return Collecs::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
            TextField::new('user'),
            CollectionField::new('nfts'),
            TextField::new('category'),
            // DateTimeField::new('createdAt'),
        ];
    }
    
}
