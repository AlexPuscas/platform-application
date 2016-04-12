<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Oro\Bundle\SoapBundle\Form\EventListener\PatchSubscriber;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IssueApiType extends  AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'csrf_protection'      => false,
                'cascade_validation'   => false,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'bugtracking_issue';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'bugtracking_issue_api';
    }
}