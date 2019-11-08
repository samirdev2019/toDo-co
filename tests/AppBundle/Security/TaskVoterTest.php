<?php
/**
 * The TaskVoterTest file doc comment
 *
 * PHP version 7.2.10
 *
 * @category ClassTest
 * @package  TaskVoterTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Security/TaskVoterTest.php
 */
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use PHPUnit\Framework\TestCase;
use AppBundle\Security\TaskVoter;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManager;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * @category ClassTest
 * @package  TaskVoterTest
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     Tests/AppBundle/Security/TaskVoterTest.php
 */
class TaskVoterTest extends TestCase
{
    /**
     * @var object instance of AccessDecisionManagerInterface
     */
    private $decisionManager;


    public function setUp():void
    {
        $this->decisionManager = $this->CreateMock(AccessDecisionManagerInterface::class);
    }
    /**
     * Method allows to create a mock of User
     *
     * @param array|null $roles
     * @return User
     */
    private function createUser(?array $roles):User
    {
        $user = $this->createMock(User::class);
        $user->method('getRoles')->willReturn($roles);
        return $user;
    }
    /**
     * Method allows to create a mock of Task
     *
     * @param User|null $user
     * @return Task|null
     */
    private function createTask(?User $user): ?Task
    {
        $task = $this->createMock(Task::class);
        $task->method('getUser')->willReturn($user);
        return $task;
        //$this->task = $task;
    }

    /**
     * @dataProvider provideTestVoteData
     */
    public function testVote($attribute, $subject, $user, $expected)
    {
        $this->decisionManager->method('decide')->willReturn(true);
        $voter = new TaskVoter($this->decisionManager);

        $tokenMock = $this->CreateMock(TokenInterface::class);
        $tokenMock->method('getUser')->willReturn($user);
        
        $this->assertEquals($expected, $voter->vote($tokenMock, $subject, [$attribute]));
    }
    /**
     * test data used by the method testVote
     */
    public function provideTestVoteData()
    {
        $user = $this->createMock(User::class);
        $task = $this->createMock(Task::class);
        $task->method('getUser')->willReturn($user);
        
        return [
            'user can delete his task' => [
                'delete',
                $task,
                $user,
                VoterInterface::ACCESS_GRANTED,
            ],
            'voter attribute different to delete' => [
                'delete2',
                $task,
                $user,
                VoterInterface::ACCESS_ABSTAIN,
            ],
            'diffrente user on delete' => [
                'delete',
                $task,
                $this->createMock(User::class),
                VoterInterface::ACCESS_DENIED,
            ],
            'annonymous user cant delete' => [
                'delete',
                $task,
                null,
                VoterInterface::ACCESS_DENIED,
            ],
            'admin can delete annonymous task' => [
                'delete',
                $this->createTask(null),
                $this->createUser(['ROLE_ADMIN']),
                VoterInterface::ACCESS_GRANTED,
            ],
        ];
    }
}
