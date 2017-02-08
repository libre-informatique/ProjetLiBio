<?php

/*
 * Copyright (C) 2015-2016 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Admin;

use Librinfo\EcommerceBundle\Admin\ProductOptionValueAdmin;
use Librinfo\EcommerceBundle\Entity\Product;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Marcos Bezerra de Menezes <marcos.bezerra@libre-informatique.fr>
 */
class PackagingAdmin extends ProductOptionValueAdmin
{
    protected $baseRouteName = 'admin_libio_packaging';
    protected $baseRoutePattern = 'libio/packaging';
    protected $classnameLabel = 'Packaging';

    /**
     * {@inheritdoc}
     */
    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);
        $query->leftJoin($query->getRootAlias() . '.option', 'option')
            ->andWhere('option.code = :code')
            ->setParameter('code', Product::$PACKAGING_OPTION_CODE)
        ;
        return $query;
    }

    /**
     * @param FormMapper $mapper
     * @todo  handle multiple locales
     */
    public function configureFormFields(FormMapper $mapper)
    {
        parent::configureFormFields($mapper);

        $builder = $mapper->getFormBuilder();

        $builder->addEventListener(FormEvents::POST_SET_DATA, function(FormEvent $event) {
            $form = $event->getForm();
            $entity = $event->getData();
            $form->get('quantity')->setData($entity->getQuantity());
            $form->get('unit')->setData($entity->getUnit());
            $form->get('bulk')->setData($entity->isBulk());
        });

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function(FormEvent $event) {
            $data = $event->getData();
            $bulk = !empty($data['bulk']);
            $data['code'] = $bulk ? 'BULK' :
                sprintf('%03d%s', (int)$data['quantity'], $data['unit'] == 'seeds' ? 'S' : 'G');
            // TODO: translate this :
            $data['value'] = $bulk ? 'Vrac' :
                sprintf('%d%s', (int)$data['quantity'], $data['unit'] == 'seeds' ? ' graines' : 'g');
            $event->setData($data);
        });


    }

    public function getNewInstance()
    {
        $entity = parent::getNewInstance();

        $repository = $this->getConfigurationPool()->getContainer()->get('sylius.repository.product_option');
        $packagingOption = $repository->findOneByCode(Product::$PACKAGING_OPTION_CODE);
        if (!$packagingOption)
            throw new \Exception('Could not find ProductOption with code ' . Product::$PACKAGING_OPTION_CODE);
        $entity->setOption($packagingOption);

        return $entity;
    }

}