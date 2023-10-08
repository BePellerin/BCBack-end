<?php

namespace App\Controller\Admin;

use App\Entity\AirDrop;
use App\Form\AirDropType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AirDropCrudController extends AbstractCrudController
{
    use Trait\adminTrait;
    
    public static function getEntityFqcn(): string
    {
        return AirDrop::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('name'),
            TextField::new('description'),
            TextField::new('nftQuantity'),
            TextField::new('category'),
            TextField::new('launchPrice'),
            ImageField::new('pict'),
        ];
    }
    
    // public function __invoke(Request $request): AirDrop
    // {
    //     $uploadedFile = $request->files->get('pict');
    //     if (!$uploadedFile) {
    //         throw new BadRequestHttpException('"file" is required');
    //     }

    //     $mediaObject = new AirDrop();
    //     $mediaObject->file = $uploadedFile;

    //     return $mediaObject;
    // }
}
