<?php
/**
 * The SecurityControllerTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category FunctionalTest
 * @package  SecurityControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/SecurityControllerTest.php
 */
namespace Tests\AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Controller\SecurityController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @category ClassTest
 * @package  SecurityControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/SecurityControllerTest.php
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * @var SecurityController
     */
    protected $controller;
    public function setUp():void
    {
        $this->controller = new SecurityController();
    }
    /**
     * This method tests the authentication with valid credentials
     *
     * @return void
     */
    public function testLoginWithValidCredentials()
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
    /**
     * This method tests the authentication with invalid credentials
     *
     * @return void
     */
    public function testLoginwithInvalideCredentials()
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
    /**
     * Tests the loginChek method
     *
     * @return void
     */
    public function testLoginCheck()
    {
        $check = $this->controller->loginCheck();
        self::assertNull($check);
    }
    /**
     * Tests the logout method
     *
     * @return void
     */
    public function testLogout()
    {
        $check = $this->controller->logout();
        self::assertNull($check);
    }
}
