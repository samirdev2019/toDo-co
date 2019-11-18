<?php
/**
 * The TaskVoter file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  TaskVoter
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Security/TaskVoter.php
 */
namespace AppBundle\Security;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

/**
 * @category Class
 * @package  TaskVoter
 * @author   Samir <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Security/TaskVoter.php
 */
class TaskVoter extends Voter
{
    const DELETE = 'delete';
    private const ATTRIBUTES = [
        self::DELETE,
    ];
    /**
     * Decides whether the access is possible or not.
     *
     * @var AccessDecisionManagerInterface
     */
    private $decisionManager;
    /**
     * The AccessDecisionManager initialization in constructor
     * that it used for make authorization decisions.
     *
     * @param AccessDecisionManagerInterface $decisionManager
     */
    public function __construct(AccessDecisionManagerInterface $decisionManager)
    {
        $this->decisionManager = $decisionManager;
    }
    /**
     * This Function returns true if the subject is instance of a task class
     * and the attribute is equals to delete that defined in the private cont attributes array
     *
     * @param string $attribute
     * @param object $subject
     * @return boolean
     */
    protected function supports($attribute, $subject)
    {
        return $subject instanceof Task
               && in_array($attribute, self::ATTRIBUTES);
    }
    /**
     * Returns true to allow access and false to denys access.
     * The $token is used to find the current user object
     * all of the complex business logic is included to determine access.
     *
     * @param string $attribute
     * @param object $subject
     * @param TokenInterface $token
     * @return boolean
     */
    public function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }
        
        // $subject is a task object, thanks to supports
        /** @var Task $task */
        $task = $subject;
        if (null === $task->getUser()) {
            if ($this->decisionManager->decide($token, ['ROLE_ADMIN'])) {
                // if user have ROLE_ADMIN then he is autorised to delete tasks attached to annonymous users
                return true;
            }
        }
        
        switch ($attribute) {
            case self::DELETE:
                return $this->isOwner($task, $user);
        }
        
        throw new \LogicException('This code should not be reached!');
    }
    /**
     * This method returns true if the actual user is the owner
     * of the task
     *
     * @param Task $task
     * @param User $user
     * @return boolean
     */
    private function isOwner(Task $task, User $user)
    {
        return $user === $task->getUser();
    }
}
