<?php
/**
 * The UserTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  UserTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Entity/UserTest.php
 */
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @category ClassTest
 * @package  UserTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Entity/UserTest.php
 *
 * @test unit class task
 */
class UserTest extends TestCase
{
    /**
     * @var object User
     */
    private $user;
    /**
     * @var object Task
     */
    private $task;

    public function setUp():void
    {
        $this->user = new user();
        $this->task = new Task();
    }
    /**
     * Tests getter and setter of the username
     *
     * @test
     */
    public function testSetGetUsername()
    {
        $this->user->setUsername('username');
        $this->assertEquals($this->user->getUsername(), 'username');
    }
    /**
     * Tests getter and setter of the password
     *
     * @test
     */
    public function testSetGetPassword()
    {
        $this->user->setpassword('password');
        $this->assertEquals($this->user->getpassword(), 'password');
    }
    /**
     * Tests getter and setter of the email
     *
     * @test
     */
    public function testSetGetEmail()
    {
        $this->user->setEmail('test@email.com');
        $this->assertEquals($this->user->getEmail(), 'test@email.com');
    }
    /**
     * Tests getter and setter of the user role
     *
     * @test
     */
    public function testSetGetRole()
    {
        $this->user->setRole('ROLE_ADMIN');
        $this->assertEquals($this->user->getRole(), 'ROLE_ADMIN');
        $this->assertEquals($this->user->getRoles(), ['ROLE_ADMIN','ROLE_USER']);
    }
    /**
     * Test of the add task method
     *
     * @test
     */
    public function testGetTasks()
    {
        $task = $this->createMock(Task::class);
        $this->user->addTask($task);
        $this->assertInstanceOf(ArrayCollection::class, $this->user->getTasks());
        $this->assertContains($task, $this->user->getTasks());
    }
}
