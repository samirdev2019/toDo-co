<?php
/**
 * The TaskControllerTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category FunctionalTest
 * @package  TaskControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/TaskControllerTest.php
 */
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @category ClassTest
 * @package  TaskControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/TaskControllerTest.php
 */
class TaskControllerTest extends WebTestCase
{
    /**
     * after the authentication user select the link 'consulter la list des taches
     *  to display tasks list
     *
     * @test
     */
    public function testTaskList()
    {
        
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $client->request('GET', '/check_login');
        $crawler = $client->request('GET', '/', [], [], [
            'PHP_AUTH_USER' => 'admin',
            'PHP_AUTH_PW' => 'admin',
        ]);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $link = $crawler->selectLink('Consulter la liste des tâches à faire')->link();
        $crawler = $client->click($link);
        $this->assertGreaterThan(
            0,
            $crawler->filter('a.btn.btn-info:contains("Créer une tâche")')->count()
        );
    }
    /**
     * This method tests the creation of task
     *
     * @return void
     */
    public function testCreateTask()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $crawler = $client->request('GET', '/tasks/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['task[title]'] = 'John Doe';
        $form['task[content]'] = 'Plat de pâtes';
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
        $form = $crawler->selectButton("Supprimer")->last()->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    /**
     * this method tests delete the task by an user has admin role
     *
     * @return void
     */
    public function testDeleteTaskAdminRole()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton("Supprimer")->last()->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(1, $crawler->filter(
            'div.alert.alert-success:contains("Superbe ! La tâche a bien été supprimée.")'
        )->count());
    }
    /**
     * this method tests task edit
     *
     * @return void
     */
    public function testEditTask()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $crawler = $client->request('GET', '/tasks');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $link = $crawler
        ->filter('a:contains("by-annonymous")')
        ->eq(1)
        ->link()
        ;
        $crawler = $client->click($link);
        $form = $crawler->selectButton('Modifier')->form();
        $form['task[title]'] = 'John Doe';
        $form['task[content]'] = 'Plat de pâtes';
        $client->submit($form);
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-success')->count());
    }
    /**
     * tests to delete a task by user had role user
     *
     * @return void
     */
    public function testDeleteTaskUserRole()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'user', 'PHP_AUTH_PW' => 'admin']);
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton("Supprimer")->last()->form();
        $client->submit($form);
        $this->assertEquals(403, $client->getResponse()->getStatusCode());
    }
    /**
     * test of toggle task methode
     *
     * @return void
     */
    public function testToggleTask()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $crawler = $client->request('GET', '/tasks');
        $form = $crawler->selectButton("Marquer comme faite")->last()->form();
        $client->submit($form);
        $crawler = $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertSame(
            1,
            $crawler->filter(
                'div.alert.alert-success:contains("a bien été marquée comme faite.")'
            )->count()
        );
    }
}
