<?php

namespace App\Controller\Admin;

use App\Entity\Delivery;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DeliveryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Delivery::class;
    }
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            IdField::new('deliveryOrder'),
            TextField::new('delivery_compagny'),
            DateTimeField::new('delivery_date'),
        ];
    }

}
