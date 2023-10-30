<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Trait\ReadOnlyTrait;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
//    trait pour être en mode lecture seule
//    use ReadOnlyTrait;
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideWhenCreating();
        yield EmailField::new('email');
        yield ArrayField::new('roles');
        yield TextField::new('password');
        yield TextField::new('userName');
        yield TextField::new('userFirstName');
        yield TextField::new('userAdress');
        yield TextField::new('userCity');
        yield TextField::new('userPC');
        yield TextField::new('userPhone');
        yield TextField::new('userPicture');
        yield BooleanField::new('userType');
    }
}
