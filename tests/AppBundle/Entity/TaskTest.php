<?php

namespace Tests\AppBundle\Entity;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
/**
 * @test unit class task
 */
class TaskTest extends TestCase
{
    private $user;
    private $createdAt;
    private $task;

    public function setUp():void
    {
        $this->user = new User();
        $this->task = new Task();
        $this->createdAt = new \DateTime;
    }
    /**
     * @test
     */
    public function testGetTitle()
    {
        $this->task->setTitle('Titletask');
        $result = $this->task->getTitle();
        $this->assertSame('Titletask', $result);
    }
    /**
     * @test
     */
    public function testGetUser()
    {
        $this->task->setUser($this->user);
        $this->assertInstanceOf(User::class,$this->task->getUser());
    }
    
    /**
     * @test
     */
    public function testGetContent()
    {
        $this->task->setContent('Content teste task');
        $this->assertEquals($this->task->getContent(),'Content teste task');
    }
    /**
     * @test
     */
    public function testGetCreatedAt()
    {
        $this->task->setCreatedAt($this->createdAt);
        $this->assertInstanceOf(\DateTime::class,$this->task->getCreatedAt());
    }
}
