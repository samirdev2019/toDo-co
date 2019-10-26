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
    
    private $decisionManager;

    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    protected function supports($attribute, $subject)
    {
        // if the attribute isn't one we support, return false
        if (!in_array($attribute, [self::DELETE])) {
            return false;
        }

        // only vote on Task objects inside this voter
        if (!$subject instanceof Task) {
            return false;
        }

        return true;
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
        if ($this->decisionManager->decide($token, ['ROLE_ADMIN']) && null === $task->getUser()) {
        // if user have ROLE_ADMIN then he is autorised to delete tasks attached to annonymous users
            return true;
        }
        if ($attribute === self::DELETE) {
            return $this->canDelete($task, $user);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canDelete(Task $task, User $user)
    {
        // if they owners of task (editors), they can delete
        if ($this->isEditor($task, $user)) {  
            return true;
        }
        // if the user is not the editor of task 
        return false;
    }

    private function isEditor(Task $task, User $user)
    {
        // to get the entity of the user who owns this task object
        return $user === $task->getUser();
    }
}
