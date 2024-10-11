<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\UkTax;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

/** @extends AbstractAdmin<UkTax> */
final class UkTaxAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $filter): void
    {
        $filter
            ->add('min')
            ->add('max')
            ->add('percent')
        ;
    }

    protected function configureListFields(ListMapper $list): void
    {
        $list
            ->add('min')
            ->add('max')
            ->add('percent')
            ->add(ListMapper::NAME_ACTIONS, null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $form): void
    {
        $form
            ->add('min')
            ->add('max')
            ->add('percent')
        ;
    }

    protected function configureShowFields(ShowMapper $show): void
    {
        $show
            ->add('min')
            ->add('max')
            ->add('percent')
        ;
    }
}
