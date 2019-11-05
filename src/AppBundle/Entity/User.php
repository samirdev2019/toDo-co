<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Table("user")
 * @ORM\Entity
 * @UniqueEntity("email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir un nom d'utilisateur.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank(message="Vous devez saisir une adresse email.")
     * @Assert\Email(message="Le format de l'adresse n'est pas correcte.")
     */
    private $email;
    /**
     * The user can have more Tasks and its removal leads to delete
     * all these last.
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Task", mappedBy="user",
     * cascade={"persist", "remove"})
     */
    private $tasks;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $role;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getSalt()
    {
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * This getter role function is modified before the users have ROLE_USER AUTOMATICALLY
     *  now user can have also their roles from database. 
     *
     * @return array
     */
    public function getRoles()
    {
        $roles [] = $this->role;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

    return array_unique($roles);
    }
    public function getRole()
    {
        return $this->role;
    }
    /**
     * This setter function allows to attribute the role to a user
     *
     * @param array $roles
     * @return self
     */
    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function eraseCredentials()
    {
    }
    /**
     * The getter of taks 
     *
     * @return mixed
     */
    public function getTasks()
    {
        return $this->tasks;
    }
    /**
     * This function allow to add an tasks to this user collection(tasks)
     *
     * @param Tasks $task
     *
     * @return self
     */
    public function addTask(Task $task): self
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks[] = $task;
            $task->setUser($this);
        }
        return $this;
    }
}
