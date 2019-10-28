<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndexRedirectionToLogin()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $crawler = $client->followRedirects();
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Redirecting to http://localhost/login',$client->getResponse()->getContent());
    }
    public function testIndexAfetrLogin()
    {
        $client = static::createClient( [], ['PHP_AUTH_USER' => 'samir123', 'PHP_AUTH_PW' => 'samir'] );
        $client->request( 'GET', '/');
        $this->assertFalse($client->getResponse()->isRedirect());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertStringContainsString('Consulter la liste des tâches à faire',$client->getResponse()->getContent());
    }
}
