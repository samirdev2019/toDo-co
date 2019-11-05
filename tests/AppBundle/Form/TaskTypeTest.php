<?php

namespace Tests\AppBundle\Form;

use AppBundle\Form\TaskType;
use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'test title',
            'content' => 'test content',
        ];
        $user = $this->createMock(User::class);
        $taskToCompare = new Task();
        $taskToCompare->setUser($user);
        // $taskToCompare will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $taskToCompare);

        $task = new Task();
        $task->setTitle('test title');
        $task->setContent('test content');
        $task->isDone(false);
        $task->setUser($user);
        $task->setCreatedAt($taskToCompare->getCreatedAt());
        // ...populate $task properties with the data stored in $formData

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
