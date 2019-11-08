<?php
/**
 * The UserType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  UserType
 * @author   Samir,sarah <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Form/UserType.php
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

/**
 * @category Class
 * @package  UserType
 * @author   Samir,sarah <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Form/UserType.php
 */
class UserType extends AbstractType
{
    /**
     * The select drop-downs has been added to allow When creating
     *  a user, it must be possible to choose a role for it.
     *  The roles listed are as follows: Role admin, Role user
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, ['label' => "Nom d'utilisateur"])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les deux mots de passe doivent correspondre.',
                'required' => true,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Tapez le mot de passe à nouveau'],
                'first_name' => 'first',
                'second_name' => 'second',
            ])
            ->add('email', EmailType::class, ['label' => 'Adresse email'])
            ->add('role', ChoiceType::class, [
                'choices'  => [
                    'administrateur' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                    
                ],
                'multiple' => false,
            ]);
        ;
    }
}
