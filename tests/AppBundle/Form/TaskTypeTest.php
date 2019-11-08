<?php
/**
 * The TaskTypeTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  TaskTypeTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Form/TaskTypeTest.php
 */
namespace Tests\AppBundle\Form;

use AppBundle\Form\TaskType;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @category ClassTest
 * @package  TaskTypeTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Form/TaskTypeTest.php
 *
 *@test unit test form TaskType class
 */
class TaskTypeTest extends TypeTestCase
{

   
    /**
     * tests the task creation form with valid information
     *
     * @return void
     */
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'test title',
            'content' => 'test content',
        ];
        $user = $this->createMock(User::class);
        $taskToCompare = new Task();
        $taskToCompare->setUser($user);
        $form = $this->factory->create(TaskType::class, $taskToCompare);

        $task = new Task();
        $task->setTitle('test title');
        $task->setContent('test content');
        $task->isDone(false);
        $task->setUser($user);
        $task->setCreatedAt($taskToCompare->getCreatedAt());

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        // check that $taskToCompare was modified as expected when the form was submitted
        $this->assertEquals($task, $taskToCompare);

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
