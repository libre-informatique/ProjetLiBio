<?php

/*
 * Copyright (C) Paweł Jędrzejewski
 * Copyright (C) 2015-2016 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\DataFixtures\Sylius;

use Doctrine\ORM\EntityManager;
use Sylius\Bundle\CoreBundle\Fixture\ProductFixture;
use Sylius\Bundle\CoreBundle\Fixture\TaxonFixture;
use Sylius\Bundle\FixturesBundle\Fixture\AbstractFixture;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Kamil Kokot <kamil.kokot@lakion.com>
 * @author Marcos Bezerra de Menezes <marcos.bezerra@libre-informatique.fr>
 */
final class SeedsProductFixture extends AbstractFixture
{
    /**
     * @var TaxonFixture
     */
    private $taxonFixture;

    /**
     * @var ProductFixture
     */
    private $productFixture;

    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var \Faker\Generator
     */
    private $faker;

    /**
     * @var OptionsResolver
     */
    private $optionsResolver;

    /**
     * @param TaxonFixture $taxonFixture
     * @param ProductFixture $productFixture
     * @param EntityManager $entityManager
     */
    public function __construct(
        TaxonFixture $taxonFixture,
        ProductFixture $productFixture,
        EntityManager $entityManager
    ) {
        $this->taxonFixture = $taxonFixture;
        $this->productFixture = $productFixture;
        $this->entityManager = $entityManager;

        $this->faker = \Faker\Factory::create();
        $this->optionsResolver =
            (new OptionsResolver())
                ->setRequired('amount')
                ->setAllowedTypes('amount', 'int')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'seeds_product';
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $options)
    {
        $options = $this->optionsResolver->resolve($options);

        $this->taxonFixture->load(['custom' => [[
            'code' => 'category',
            'name' => 'Catégorie',
            'children' => [
                [
                    'code' => 'seeds',
                    'name' => 'Semences',
                    'children' => [
                        ['code' => 'seeds_LFE',  'name' => 'Légumes-feuille'],
                        ['code' => 'seeds_LFR',  'name' => 'Légumes-fruit'],
                        ['code' => 'seeds_LRA',  'name' => 'Légumes-racine et bulbes'],
                        ['code' => 'seeds_CAM',  'name' => 'Condimentaires, alimentaires et médicinales'],
                    ]
                ]
            ]
        ]]]);

        $products = [];
        $varieties = $this->getVarieties($options['amount']);
        foreach ($varieties as $variety) {
            $products[] = [
                'name' => (string)$variety,
                'code' => $this->faker->uuid, // TODO in listener
                'main_taxon' => 'seeds_LFR',      // TODO (Variety taxon)
                'taxons' => ['seeds_LFR'],        // TODO (Variety taxon)
                'images' => [
                    'main' => sprintf('%s/../../Resources/fixtures/%s', __DIR__, 'tomate-stpierre.jpg'),  // TODO (Variety media)
                    'thumbnail' => sprintf('%s/../../Resources/fixtures/%s', __DIR__, 'tomate-stpierre.jpg'),  // TODO (Variety media)
                ],
            ];
        }

        $this->productFixture->load(['custom' => $products]);
    }

    /**
     * {@inheritdoc}
     */
    protected function configureOptionsNode(ArrayNodeDefinition $optionsNode)
    {
        $optionsNode
            ->children()
                ->integerNode('amount')->isRequired()->min(0)->end()
        ;
    }

    /**
     * @param int $amount
     *
     * @return string
     */
    private function getVarieties($amount)
    {
        return $this->entityManager
            ->getRepository('LibrinfoVarietiesBundle:Variety')
            ->findBy([], null, $amount);
    }
}