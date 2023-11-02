<?php

namespace App\Controller\Admin;

use App\Entity\Picture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Picture::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Images')
            ->setEntityLabelInSingular('Image')
            ->setPageTitle('index', 'Administration des images - TheGoldenGun');
    }
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideWhenCreating()
            ->hideOnForm();
        yield TextField::new('pictureName');
        yield CollectionField::new('products');

    }
}
