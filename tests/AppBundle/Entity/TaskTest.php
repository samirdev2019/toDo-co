<?php
/**
 * The TaskTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  TaskTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Entity/TaskTest.php
 */
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * @category ClassTest
 * @package  TaskTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Entity/TaskTest.php
 *
 * @test unit class task
 */
class TaskTest extends TestCase
{
    /**
     * @var object User
     */
    private $user;
    /**
     * @var object \DateTime
     */
    private $createdAt;
    /**
     * @var object Task
     */
    private $task;

    public function setUp():void
    {
        $this->user = new User();
        $this->task = new Task();
        $this->createdAt = new \DateTime;
    }
    /**
     * Tests getter and setter of title
     */
    public function testGetTitle()
    {
        $this->task->setTitle('Titletask');
        $result = $this->task->getTitle();
        $this->assertSame('Titletask', $result);
    }
    /**
     * Tests getter and setter of user
     */
    public function testGetUser()
    {
        $this->task->setUser($this->user);
        $this->assertInstanceOf(User::class, $this->task->getUser());
    }
    /**
     * Tests getter and setter of content
     */
    public function testGetContent()
    {
        $this->task->setContent('Content teste task');
        $this->assertEquals($this->task->getContent(), 'Content teste task');
    }
    /**
     * Tests getter and setter of creation date
     */
    public function testGetCreatedAt()
    {
        $this->task->setCreatedAt($this->createdAt);
        $this->assertInstanceOf(\DateTime::class, $this->task->getCreatedAt());
    }
}
