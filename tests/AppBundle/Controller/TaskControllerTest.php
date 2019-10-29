<?php
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{   
    
    public function testTaskList()
    {
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin'] );
        $client->request( 'GET', '/check_login' );
        $crawler = $client->request( 'GET', '/', [], [], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ] );
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $client->click($link);
        //$this->assertSame(1, $crawler->filter('a.btn.btn-info')->count());
        $this->assertGreaterThan(
            0,
            $crawler->filter('a.btn.btn-info:contains("Créer une tâche")')->count()
        );
    }
    public function testCreateAction()
    {
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin'] );
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'John Doe';
        $form['task[content]'] = 'Plat de pâtes';
        $client->submit($form);
        $crawler = $client->followRedirect();
        //echo $client->getResponse()->getContent();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
    public function testEditAction()
    {
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin'] );
        $crawler = $client->request('GET','/tasks');
        $this->assertEquals(200,$client->getResponse()->getStatusCode());
        $link = $crawler
        ->filter('a:contains("by-annonymous")') // find all links with the text "Greet"
        ->eq(1) // select the second link in the list
        ->link()
        ;
        // and click it
        $crawler = $client->click($link);
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'John Doe';
        $form['task[content]'] = 'Plat de pâtes';
        $client->submit($form);
        $this->assertEquals(302,$client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
    
}
