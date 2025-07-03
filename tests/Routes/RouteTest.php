<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RouteTest extends WebTestCase
{
    public function testSomething(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', 'login');

        $form = $crawler->selectButton("Se connecter")->form([
        '_username' => 'laporte.franck@hotmail.fr',
        '_password' => 'password']);

        $client->submit($form);

        $crawler = $client->request('GET', 'recipes/new');

        $form = $crawler->selectButton("Créer une recette")->form([
        'recipe_type_form[name]' => 'Salade fraîche',
        'recipe_type_form[description]' => 'Une salade composée de légumes frais',
        "recipe_type_form[time]" => "3",
        // Ajoute d'autres champs ici si nécessaire (ex: 'recipe[ingredient]' => ... )
        ]);

    $button  = $crawler->filter('button:contains("Créer une recette")');
    
    $client->submit($form);

    // Vérifie une redirection
    $this->assertResponseRedirects();

    // Suivre la redirection et vérifier un message
    $client->followRedirect();
    $this->assertSelectorExists('.alert-success');
    }
}
