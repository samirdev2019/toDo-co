<?php
/**
 * The Task file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  Task
 * @author   Samir,sarah <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Entity/Task.php
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * The Entity class of Task
 *
 * @category Class
 * @package  Task
 * @author   Samir,sarah <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Entity/Task.php
 *
 * @ORM\Entity
 * @ORM\Table
 */
class Task
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Vous devez saisir un titre.")
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(message="Vous devez saisir du contenu.")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDone;
    /**
     * Each task is linked to the user that it had been created
     * nullable is true because the tasks already created, they must
     *  be attached to an "anonymous" user.
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="tasks")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user;
    /**
     * The constructor where the creation date and isDone are initialized
     */
    public function __construct()
    {
        $this->createdAt = new \Datetime();
        /**
         * @var bool initially it is assumed that the task is not done
         */
        $this->isDone = false;
    }
    /**
     * the getter of id
     *
     * @return int $id the id of task
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * The getter of creation date
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    /**
     * The setter of creation date
     *
     * @param Datetime $createdAt
     * @return void
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }
    /**
     * The getter of title
     *
     * @return string the title of task
     */
    public function getTitle()
    {
        return $this->title;
    }
    /**
     * The title setter
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    /**
     * The content getter
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
    /**
     * The content setter
     *
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }
    /**
     * the isser isdone
     *
     * @return boolean
     */
    public function isDone()
    {
        return $this->isDone;
    }
    /**
     * This function allows to switch the task done or not done yet
     *
     * @param boolean $flag
     * @return void
     */
    public function toggle($flag)
    {
        $this->isDone = $flag;
    }
    /**
     * The user getter
     *
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }
    /**
     * The user setter
     *
     * @param User|null $user
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
