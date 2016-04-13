<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;
use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType;

class LoadIssueTypes extends AbstractDashboardFixture
{
    protected $issueTypeNames = [
        'Bug',
        'SubTask',
        'Task',
        'Story',
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->issueTypeNames as $issueTypeName) {
            $issueType = new IssueType();
            $issueType
                ->setName($issueTypeName)
                ->setDescription($issueTypeName);

            $manager->persist($issueType);
            $manager->flush();
        }
    }
}
