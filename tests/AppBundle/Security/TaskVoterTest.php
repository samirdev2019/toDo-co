<?php

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

class TaskVoterTest extends TestCase
{
    private $admin;
    private $user;
    private $decisionManager;
    public function setUp():void
    {
        $this->admin = new User();
        $this->admin->setRole('ROLE_ADMIN');
        $this->user = new User();
        $this->user->setRole('ROLE_USER');
        //$this->user1 = $this->$this->createUser(1,['ROLE_USER']);
        
        $this->decisionManager = $this->CreateMock(AccessDecisionManagerInterface::class);
        $this->decisionManager->method('decide')->willReturn(true);
    
    }

    private function createUser(int $id, ?array $roles):User
    {
        $user = $this->createMock(User::class);
        $user->method('getId')->willReturn($id);
        $user->method('getRoles')->willReturn($roles);

        return $user;
        
    } 
    private function createTask(?User $user): ?Task
    {
        $task = $this->createMock(Task::class);
        $task->method('getUser')->willReturn($user);
        return $task;
        //$this->task = $task;
    } 
    public function createToken(?User $user)
    {
        $token = $this->CreateMock(TokenInterface::class);
        $token->method('getUser')->willReturn($user);
        $token->method('isAuthenticated')->willReturn(true);
        $token->method('getAttribute')->willReturn('delete');
        //$token->method('getRoles')->willReturn($user->getRoles());
        return $token;
    }
    public function provideCases()
    { 
        //$user = $this->createUser(1, ['ROLE_USER']);
        
        yield 'owner can delete' => [
            'delete',
            $this->createTask($this->admin),
            $this->admin,
            //Voter::ACCESS_DENIED
            Voter::ACCESS_GRANTED
        ];
        
    }   
    
    /**
     * @dataProvider provideCases
     */
    public function testVote(
        string $attribute,
        Task $task,
        ?User $user,
        $expectedVote
    ) {
        $voter = new TaskVoter($this->decisionManager);
        //$token = new AnonymousToken('secret', 'anonymous');
        $token = $this->createToken(null);
        if ($user) {
            $token = $this->createToken($user);
        }

        $this->assertSame(
            $expectedVote,
            $voter->vote($token, $task, [$attribute])
        );
       
    }   
    public function testAnnonymousUser()
    {
        $task = new Task();
        $attribute = 'delete';

        $token = $this->CreateMock(TokenInterface::class);
        $token->method('getUser')->willReturn(null);
        $token->method('isAuthenticated')->willReturn(true);
        $token->method('getAttribute')->willReturn('delete');
        $voter = new TaskVoter($this->decisionManager);
        $this->assertSame(
            Voter::ACCESS_DENIED,
            $voter->vote($token, $task, [$attribute])
        );
    } 
    public function testThrowException()
    {
        $voter = $this
            ->getMockBuilder('JMS\Serializer\Serializer')
            ->disableOriginalConstructor()
            ->method('voteOnAttribute')->will($this->throwException(new Exception))
             
            ->getMock();
        

        // $stub->doSomething() throws Exception
        $voter->voteOnAttribute();
    }   
        
   

  

}
