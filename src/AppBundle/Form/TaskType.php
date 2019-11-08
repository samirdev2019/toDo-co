<?php
/**
 * The TaskType file doc comment
 *
 * PHP version 7.2.10
 *
 * @category Class
 * @package  TaskType
 * @author   Samir,sarah <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Form/TaskType.php
 */
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * @category Class
 * @package  TaskType
 * @author   Samir,sarah <allabsamir666@gmail.com>
 * @license  Copyright 2019 General public license
 * @link     src/AppBundle/Form/TaskType.php
 */
class TaskType extends AbstractType
{

    /**
     * The builder form method where the author is commented
     * because When editing the task, the author can not be edited.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('content', TextareaType::class)
            //->add('author') ===> must be the user authenticated
        ;
    }
}
