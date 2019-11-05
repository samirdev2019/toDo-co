<?php

namespace AppBundle\Security;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class TaskVoter extends Voter
{
    const DELETE = 'delete';
    private const ATTRIBUTES = [
        self::DELETE,
    ];
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Task 
               && in_array($attribute, self::ATTRIBUTES);
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        
        // $subject is a task object, thanks to supports
        /** @var Task $task */
        $task = $subject;
        if(null === $task->getUser()) {
            if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
                // if user have ROLE_ADMIN then he is autorised to delete tasks attached to annonymous users
                return true;
            }
            return false;
        }
        
        // if ($attribute === self::DELETE) {
        //     return $this->canDelete($task, $user);
        // }
       
        switch ($attribute) {
            case self::DELETE:
                return $this->isOwner($task,$user);
        }
        throw new \LogicException('This code should not be reached!');
    }

    private function isOwner(Task $task, User $user)
    {
        // if they owners of task they can delete
        return $user === $task->getUser();
        //return $user->getId() === $task->getUser()->getId();
    }
}
