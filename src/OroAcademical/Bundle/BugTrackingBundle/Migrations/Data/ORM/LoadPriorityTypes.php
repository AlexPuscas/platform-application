<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Priority;

class LoadPriorityTypes extends AbstractDashboardFixture
{
    protected $priorityNames = [
        'Blocker',
        'Critical',
        'Major',
        'Trivial',
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->priorityNames as $index => $priorityName) {
            $priority = new Priority();
            $priority
                ->setName($priorityName)
                ->setDescription($priorityName)
                ->setPriority($index);

            $manager->persist($priority);
            $manager->flush();
        }
    }
}
