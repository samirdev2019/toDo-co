<?php
namespace AppBundle\DataFixtures;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures implements ORMFixtureInterface
{
    private $encoder;
    /**
     * The constructor class with intialisation of UserPasswordEncoderInterface
     *
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');
        $username = ['admin','user'];
        $roles = ['ROLE_ADMIN','ROLE_USER'];
        
        for($i=0; $i<=1; $i++)
        {
            $user = new User();
            
            $user->setUsername($username[$i]);
            $user->setEmail($faker->email);
            $user->setRoles([$roles[$i]]);
            $password = $this->encoder->encodePassword($user, 'admin');
            $user->setPassword($password);
            $manager->persist($user);
            for($j=0; $j<=20; $j++) {
                $task = new Task ();
                $task->setCreatedAt(new \DateTime());
                $task->setTitle($faker->jobTitle);
                $task->setContent($faker->sentence($nbWords = 6, $variableNbWords = true));
                $task->isDone($faker->boolean);
                $task->setUser($user);
                $manager->persist($task);
            }
            for($k=0; $k<=20; $k++) {
                $task = new Task ();
                $task->setCreatedAt(new \DateTime());
                $task->setTitle($faker->jobTitle);
                $task->setContent($faker->sentence($nbWords = 6, $variableNbWords = true));
                $task->isDone($faker->boolean);
                $manager->persist($task);            }
            
        }
       $manager->flush();
    }
}
