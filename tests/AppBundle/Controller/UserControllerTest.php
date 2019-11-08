<?php
/**
 * The UserControllerTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  UserControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/UserControllerTest.php
 */
namespace Tests\AppBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * @category FunctionalTest
 * @package  UserControllerTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Controller/UserControllerTest.php
 */
class UserControllerTest extends WebTestCase
{
    private $client = null;
  
    public function setUp():void
    {
        $this->client = static::createClient([], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin']);
    }
    /**
     * The functional test of creating an user with a ROLE
     *
     * @return void
     */
    public function testCreateUser()
    {
        $crawler = $this->client->request('GET', '/');
        $link = $crawler->selectLink('Créer un utilisateur')->link();
        $crawler = $this->client->click($link);
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'kadour';
        $form['user[password][first]'] = 'password';
        $form['user[password][second]'] = 'password';
        $form['user[email]'] = 'kadour@email.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);
        $crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été ajouté.');
        $this->assertStringContainsString('Liste des utilisateurs', $this->client->getResponse()->getContent());
    }
    /**
     * This methode tests the bad confirmation of password
     *
     * @return void
     */
    public function testFalseConfimationPassword()
    {
        $crawler = $this->client->request('GET', '/users/create');
        $form = $crawler->selectButton('Ajouter')->form();
        $form['user[username]'] = 'kadour';
        $form['user[password][first]'] = 'password1';
        $form['user[password][second]'] = 'password2';
        $form['user[email]'] = 'test@email.com';
        $form['user[role]'] = 'ROLE_USER';
        $this->client->submit($form);
        $this->assertStringContainsString(
            'Les deux mots de passe doivent correspondre.',
            $this->client->getResponse()->getContent()
        );
    }
    /**
     * Editing user and changin his role
     * after the consultation of the users list the user click on the link edit
     * where will get the form for editing the user and he can change his role also
     * after that the user will redirect to user liste again
     *
     * @return void
     */
    public function testEditUser()
    {
        $crawler = $this->client->request('GET', '/users');
        $link = $crawler
        ->filter('a:contains("Edit")')
        ->eq(1)
        ->link()
        ;
                        
        $crawler = $this->client->click($link);
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $form = $crawler->selectButton('Modifier')->form();
        $form['user[username]'] = 'laurant';
        $form['user[password][first]'] = 'password1';
        $form['user[password][second]'] = 'password1';
        $form['user[role]'] = 'ROLE_ADMIN';
        $this->client->submit($form);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
        $crawler = $this->client->followRedirect();
        $this->assertTrue($this->client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été modifié');
        $this->assertStringContainsString('Liste des utilisateurs', $this->client->getResponse()->getContent());
    }
}
