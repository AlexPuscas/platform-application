<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;

use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType;

class LoadIssueTypes extends AbstractDashboardFixture
{
    /** @var array */
    protected $issueTypeNames = [
        IssueType::BUG_TYPE,
        IssueType::SUB_TASK_TYPE,
        IssueType::TASK_TYPE,
        IssueType::STORY_TYPE,
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
