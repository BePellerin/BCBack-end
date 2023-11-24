<?php

namespace App\Controller\Admin;

use App\Entity\AirDrop;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpKernel\Attribute\AsController;


#[AsController]
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
            NumberField::new('nftQuantity'),
            TextField::new('category'),
            NumberField::new('launchPrice'),
            // ImageField::new('pict'),
        ];
    }

    // public function __invoke(Request $request): AirDrop
    // {

    //     // if (!$uploadedFile) {
    //     //     throw new BadRequestHttpException('imageFile is required');
    //     // }

    //     $airDrop = new AirDrop();
    //     $airDrop->setImageName($request->request->get('name'));
    //     $airDrop->setImageFile($request->files->get('file'));
    //     $airDrop->setCreatedAt(new \DateTimeImmutable());
    //     return $airDrop;
    // }
}
