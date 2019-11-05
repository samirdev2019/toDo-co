<?php

namespace Tests\AppBundle\Entity;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @test unit class task
 */
class UserTest extends TestCase
{
    private $user;
    private $task;

    public function setUp():void
    {
        $this->user = new user();
        $this->task = new Task();
    }
     /**
     * @test
     */
    public function test_Set_Get_username()
    {
        $this->user->setUsername('username');
        $this->assertEquals($this->user->getUsername(),'username');
    }
    /**
     * @test
     */
    public function test_Set_Get_password()
    {
        $this->user->setpassword('password');
        $this->assertEquals($this->user->getpassword(),'password');
    }
    public function test_Set_Get_Email()
    {
        $this->user->setEmail('test@email.com');
        $this->assertEquals($this->user->getEmail(),'test@email.com');
    }
    public function testSetGetRole()
    {
        $this->user->setRole('ROLE_ADMIN');
        $this->assertEquals($this->user->getRole(),'ROLE_ADMIN');
        $this->assertEquals($this->user->getRoles(),['ROLE_ADMIN','ROLE_USER']);
    }
   
    public function testGetTasks()
    {
        $task = $this->createMock(Task::class);
        $this->user->addTask($task);
        $this->assertInstanceOf(ArrayCollection::class,$this->user->getTasks());
        $this->assertContains($task,$this->user->getTasks());
    }
}
