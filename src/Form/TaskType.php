<?php

namespace App\Form;

use App\Entity\Task;
use App\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to create and manipulate tasks.
 */
class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['autofocus' => true],
                'label' => 'label.name',
            ])
            ->add('description', null, [
                'attr' => ['rows' => 10],
                'label' => 'label.description',
            ])
            ->add('start_time', DateTimePickerType::class, [
                'label' => 'label.start_time',
            ])
            ->add('end_time', DateTimePickerType::class, [
                'label' => 'label.end_time',
            ])
            ->add('assigned_person', null, [
                'label' => 'label.assigned_person',
            ])
            ->add('status', ChoiceType::class, [
                'label' => 'label.status',
                'choices'  => array(
                    'TODO' => 'TODO',
                    'In Progress' => 'In Progress',
                    'Done' => 'Done',
                ),
                
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
