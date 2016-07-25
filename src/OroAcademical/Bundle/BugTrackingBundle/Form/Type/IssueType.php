<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Form\Type;

use Doctrine\ORM\EntityRepository;

use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType as Type;

class IssueType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'summary',
                'text',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.summary.label',
                ]
            )
            ->add(
                'code',
                'text',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.code.label',
                ]
            )
            ->add(
                'description',
                'text',
                [
                    'required' => false,
                    'label' => 'bugtracking.issue.description.label',
                ]
            )
            ->add(
                'type',
                'entity',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.taskType.label',
                    'class'  => 'OroAcademicalBugTrackingBundle:IssueType',
                    'query_builder' => function (EntityRepository $entityRepository) {
                        $queryBuilder = $entityRepository->createQueryBuilder('t');

                        return $queryBuilder
                            ->where($queryBuilder->expr()->notLike('t.name', ':type'))
                            ->setParameter('type', '%' . Type::SUB_TASK_TYPE . '%');
                    },
                ]
            )
            ->add(
                'priority',
                'entity',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.taskPriority.label',
                    'class' => 'OroAcademicalBugTrackingBundle:Priority',
                ]
            )
            ->add(
                'resolution',
                'entity',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.taskResolution.label',
                    'class' => 'OroAcademicalBugTrackingBundle:Resolution',
                ]
            )
            ->add(
                'status',
                'integer',
                [
                    'required' => false,
                    'label' => 'bugtracking.issue.status.label',
                ]
            )
            ->add(
                'reporter',
                'entity',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.taskReporter.label',
                    'class' => 'OroUserBundle:User'
                ]
            )
            ->add(
                'assignee',
                'entity',
                [
                    'required' => true,
                    'label' => 'bugtracking.issue.taskAssignee.label',
                    'class' => 'OroUserBundle:User',
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Issue::class,
                'cascade_validation' => true,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bugtracking_issue';
    }
}
