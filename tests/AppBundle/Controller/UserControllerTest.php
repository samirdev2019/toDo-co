<?php 

namespace Tests\AppBundle\Controller;

use Symfony\Component\BrowserKit\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    private $client = null;
  
  public function setUp():void
  {
    $this->client = static::createClient( [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => 'admin'] );
  }
  
  public function testCreateUserAction()
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
    $this->assertTrue( $this->client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été ajouté.' );
    $this->assertStringContainsString( 'Liste des utilisateurs', $this->client->getResponse()->getContent() );
    
    
  }
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
    $this->assertStringContainsString( 'Les deux mots de passe doivent correspondre.', $this->client->getResponse()->getContent() ); 
  }
  public function testEditUserAction()
  {
    $crawler = $this->client->request('GET','/users');
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
    $this->assertTrue( $this->client->getResponse()->isSuccessful(), 'L\'utilisateur a bien été modifié' );
    $this->assertStringContainsString( 'Liste des utilisateurs', $this->client->getResponse()->getContent() );
  }   
}
