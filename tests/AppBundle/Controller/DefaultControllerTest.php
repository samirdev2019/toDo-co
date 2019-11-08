<?php
/**
 * The DefaultControllerTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  DefaultControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/DefaultControllerTest.php
 */
namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @category FunctionalTest
 * @package  DefaultControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/DefaultControllerTest.php
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * This function tests the redirection to the page login
     *
     * @return void
     */
    public function testIndexRedirectionToLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $crawler = $client->followRedirects();
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString(
            'Redirecting to http://localhost/login',
            $client->getResponse()->getContent()
        );
    }
    /**
     * This function test authentication and access to the homepage after authentication
     *
     * @return void
     */
    public function testIndexAfetrLogin()
    {
        $client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
        $client->request('GET', '/');
        $this->assertFalse($client->getResponse()->isRedirect());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString(
            'Consulter la liste des tâches à faire',
            $client->getResponse()->getContent()
        );
    }
}
