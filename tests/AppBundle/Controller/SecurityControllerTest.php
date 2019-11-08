<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    protected $controller;
    public function setUp():void
    {
        $this->controller = new SecurityController();
    }
    public function testLoginActionValidCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'admin';
        $form['_password'] = 'admin';
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $client->followRedirect();
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString(
            'Consulter la liste des tâches à faire',
            $client->getResponse()->getContent()
        );
    }
    public function testLoginActionInvalideCredentials()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('Se connecter')->form();
        $form['_username'] = 'invalidUsername';
        $form['_password'] = 'invalidPassword';
        $crawler = $client->submit($form);
        $this->assertTrue($client->getResponse()->isRedirect());
        $crawler = $client->followRedirect();
        $this->assertSame(1, $crawler->filter('div.alert.alert-danger:contains("Invalid credentials.")')->count());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
    public function testLoginCheck()
    {
        $check = $this->controller->loginCheck();
        self::assertNull($check);
    }
    public function testLogout()
    {
        $check = $this->controller->logoutCheck();
        self::assertNull($check);
    }
}
