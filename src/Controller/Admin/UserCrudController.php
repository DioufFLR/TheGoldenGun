<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\ReadOnlyTrait;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setEntityLabelInPlural('Utilisateurs')
            ->setEntityLabelInSingular('Utilisateur')
            ->setPageTitle('index', 'Administration des utilisateurs - TheGoldenGun');
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideWhenCreating()
            ->hideOnForm();
        yield EmailField::new('email');
        yield ArrayField::new('roles');
        yield TextField::new('userName');
        yield TextField::new('userFirstName');
        yield TextField::new('userAdress');
        yield TextField::new('userCity');
        yield TextField::new('userPC');
        yield TextField::new('userPhone');
        yield ImageField::new('userPicture')
            ->setUploadDir('public/assets/css/img')
            ->hideOnIndex();
        yield BooleanField::new('userType');
    }
}
