<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Priority;

class LoadPriorityTypes extends AbstractDashboardFixture
{
    protected $priorityNames = [
        Priority::BLOCKER_PRIORITY,
        Priority::CRITICAL_PRIORITY,
        Priority::MAJOR_PRIORITY,
        Priority::TRIVIAL_PRIORITY,
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
