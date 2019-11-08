<?php
/**
 * The UserTypeTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  UserTypeTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Form/UserTypeTest.php
 */
namespace Tests\AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Form\Forms;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @category ClassTest
 * @package  UserTypeTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Form/UserTypeTest.php
 */
class UserTypeTest extends TypeTestCase
{
    /**
     * Ajouter des extensions personnalisées invalide_message
     *
     * @return ValidatorExtension
     */
    protected function getExtensions()
    {
        $validator = Validation::createValidator();
        return [
            new ValidatorExtension($validator),
        ];
    }
    /**
     * tests the User creation form with valid information including user role
     *
     * @return void
     */
    public function testSubmitUserValidData()
    {
       
        $formData = [
            'username' => 'testname',
            'email' => 'teste@email.com',
            'password' => [
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'first' => 'password',
                'second' => 'password'],
            'role' => 'ROLE_USER',
        ];
        $userToCompare = new User();
        $form = $this->factory->create(UserType::class, $userToCompare);
        $user = new User();
        $user->setUsername($formData['username']);
        $user->setEmail($formData['email']);
        $user->setPassword('password');
        $user->setRole($formData['role']);
        
        $form->submit($formData);
        
        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($user, $userToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
