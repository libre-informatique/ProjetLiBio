<?php

/*
 * This file is part of the Lisem Project.
 *
 * Copyright (C) 2015-2017 Libre Informatique
 *
 * This file is licenced under the GNU GPL v3.
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Step\Acceptance;

class SeedBatch extends \WebGuy
{
    public function createPlot($producerName)
    {
        $plotName = $this->getRandName() . '-plot';
        $this->wantTo('Create Plot ' . $plotName);
        $this->amOnPage('/lisem/librinfo/seedbatch/plot/create');
        $this->fillField("//input[contains(@id,'_name')]", $plotName);

        $this->selectSearchDrop('_producer_autocomplete_input', $this->getRandNbr());

        $this->fillField("//input[contains(@id,'_city')]", $plotName . '-city');
        $this->fillField("//input[contains(@id,'_zip')]", $this->getRandNbr());

        $this->generateCode();

        $this->clickCreate();

        return $plotName;
    }

    public function createProducer()
    {
        $producerName = $this->getRandName() . '-producer';
        $this->wantTo('Create a producer ' . $producerName);
        $this->amOnPage('/lisem/librinfo/seedbatch/seed-producer/create');

        //$this->click("//li[2]/div/label/div/ins"); //ugly work
        /* @todo: find a way to click without use li[2] ... */
        $this->click("//ul[contains(@id, '_isIndividual')]/li[2]/div/label/div/ins"); //ugly too

        $this->selectDrop('_title', 'Mme');
        $this->fillField("//input[contains(@id,'_firstname')]", $producerName);
        $this->fillField("//input[contains(@id,'_lastname')]", 'last-' . $producerName);
        $this->fillField("//input[contains(@id,'_email')]", $producerName . '@lisem.eu');
        $this->clickCreate();

        return $producerName;
    }

    public function create()
    {
        $seedBatchName = $this->getRandName() . '-seedbatch';
        $this->wantTo('Create Seed Batch' . $seedBatchName);
        $this->amOnPage('lisem/librinfo/seedbatch/seedbatch/create');

        return $seedBatchName;
    }

    public function fullCreate()
    {
        $selProducer = $this->createProducer();
        $selPlot = $this->createPlot($selProducer);
        $selSeedBatch = $this->create();

        return $selSeedBatch;
    }
}