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

// @group scenarii
 // @group ecommerce

use Step\Acceptance\Lisem as LisemTester;
use Step\Acceptance\Ecommerce as EcommerceTester;
use Step\Acceptance\Sylius as SyliusTester;

$lisem = new LisemTester($scenario);
$ecommerce = new EcommerceTester($scenario);
$sylius = new SyliusTester($scenario);

$lisem->loginLisem();
$lisem->amGoingTo('Test Order from Sylius To Lisem');

$randNbr = $lisem->getRandNbr();
$randSelEmail = $lisem->getRandName() . '@lisem.eu';
$randName = $lisem->getRandName();

$randSelEmail = $sylius->createAccount();
//ActiveUser($lisem, $randSelEmail);
$ecommerce->activeAccount($randSelEmail);
$sylius->loginSylius($randSelEmail);
// CreateCmd($lisem);
//CheckCmd($lisem, $randName);
// $ecommerce->checkOrder($randSelEmail);

//$ecommerce->checkOrder('sel-8053@lisem.eu');

function CreateCmd($webGuy)
{
    $webGuy->amGoingTo('CreateCmd');
    $webGuy->amOnPage('/');
    // $webGuy->amOnPage("/taxons/legumes-fruit");
    // $webGuy->click("Semences");
    // $webGuy->click("Légumes-fruit");
    // $webGuy->scrollTo("Carotte nantaise", 100, 100);
    //$webGuy->click("Carotte nantaise");
    $webGuy->amOnPage('/products/carotte-nantaise'); /* Hum... Carotte */
    $webGuy->click("//button[@type='submit']");
    //$webGuy->wait(5);
    //$webGuy->waitForText('Paiement', 30);
    //$webGuy->waitForElementVisible("(//a[contains(@href, '/checkout')])[2]", 30);
    $webGuy->scrollTo("(//a[contains(@href, '/checkout')])[2]");
    $webGuy->click("(//a[contains(@href, '/checkout')])[2]");
    //    $webGuy->click("(//a[contains(text(),'Paiement')])[2]");
    $webGuy->fillField('#sylius_checkout_address_shippingAddress_firstName', 'selfirst');
    $webGuy->fillField('#sylius_checkout_address_shippingAddress_lastName', 'sellast');
    $webGuy->fillField('#sylius_checkout_address_shippingAddress_street', 'sel street');
    $webGuy->fillField('#sylius_checkout_address_shippingAddress_city', 'sel city');
    $webGuy->fillField('#sylius_checkout_address_shippingAddress_postCode', '29');
    $webGuy->scrollTo('#next-step');
    $webGuy->click('#next-step');
    $webGuy->waitForText('Suivant', 30);
    $webGuy->scrollTo('#next-step');
    $webGuy->click('#next-step');
    $webGuy->waitForText('Suivant', 30);
    $webGuy->scrollTo('#next-step');
    $webGuy->click('#next-step');

    $webGuy->waitForText('Récapitulatif de votre commande', 30);
    $webGuy->scrollTo("//button[@type='submit']");
    $webGuy->click("//button[@type='submit']");
    $webGuy->see('Merci ! Votre commande a bien été prise en compte.', '#sylius-thank-you');
}
