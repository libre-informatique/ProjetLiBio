<?php
$I = new WebGuy($scenario);
$I->wantTo("RelaPubCept");
$I->amOnPage("/app_dev.php/admin/login");
$I->fillField("//input[@id='_username']", "lisem@lisem.eu");
$I->fillField("//input[@id='_password']", "lisem");
$I->click("//button[@type='submit']");
$I->click("//li[7]/a/span");
$I->click("//li[7]/ul/li[2]/a/span");
$I->click("Groupes");
$I->click("Ajouter");
$I->fillField("//input[contains(@id,'name')]", "SelGroup");
$I->fillField("//input[contains(@id,'code')]", "SELG");
$I->fillField("//textarea[contains(@id,'description')]", "Groupe de Test Selenium");
$I->click("//button[@name='btn_create_and_list']");
//$I->verifyText("//body/div/div/section/div", 'L\'élément "SELG SelGroup" a été créé avec succès.');
$I->click("Liste des Tiers");
$I->click("Ajouter un Tiers");
$I->click("//ul[contains(@id,'isIndividual')]/li[2]/div/label/div/ins");
$I->selectOption("//select[contains(@id,'title')]", "M");
$I->fillField("//input[contains(@id,'firstname')]", "Sel");
$I->fillField("//input[contains(@id,'lastname')]", "Nium");
$I->fillField("//input[contains(@id,'name')]", "Selenium");
$I->fillField("//input[contains(@id,'email')]", "selenium@lisem.fr");