<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Data\Demo\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;

class LoadIssues extends AbstractDashboardFixture
{
    /** @var array */
    protected $fixtureConditions = array(
        'Lorem ipsum dolor sit amet, consectetuer adipiscing elit',
        'Aenean commodo ligula eget dolor',
        'Aenean massa',
        'Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus',
        'Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem',
        'Nulla consequat massa quis enim',
        'Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu',
        'In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo',
        'Nullam dictum felis eu pede mollis pretium',
        'Integer tincidunt',
        'Cras dapibus',
        'Vivamus elementum semper nisi',
        'Aenean vulputate eleifend tellus',
        'Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim',
        'Aliquam lorem ante, dapibus in, viverra quis, feugiat',
        'Aenean imperdiet. Etiam ultricies nisi vel',
        'Praesent adipiscing',
        'Integer ante arcu',
        'Curabitur ligula sapien',
        'Donec posuere vulputate'
    );

    /** @var string */
    protected $summary = 'Issue';

    /** @var string */
    protected $code = 'I';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository('OroUserBundle:User')->findAll();
        $types = $manager->getRepository('OroAcademicalBugTrackingBundle:IssueType')->findAll();
        $priorities = $manager->getRepository('OroAcademicalBugTrackingBundle:Priority')->findAll();
        $resolutions = $manager->getRepository('OroAcademicalBugTrackingBundle:Resolution')->findAll();
        $usersCount = count($users);
        $typesCount = count($types);
        $prioritiesCount = count($priorities);
        $resolutionsCount = count($resolutions);
        $date = new \DateTime();

        foreach ($this->fixtureConditions as $index => $condition) {
            $issue = new Issue();
            $issue
                ->setSummary(sprintf('%s %d', $this->summary, $index))
                ->setCode(sprintf('%s%d', $this->code, $index))
                ->setDescription($condition)
                ->setType($types[rand(0, $typesCount - 1)])
                ->setPriority($priorities[rand(0, $prioritiesCount - 1)])
                ->setResolution($resolutions[rand(0, $resolutionsCount - 1)])
                ->setStatus(rand(0, 1))
                ->setReporter($users[rand(0, $usersCount - 1)])
                ->setAssignee($users[rand(0, $usersCount - 1)])
                ->setCreated(clone $date->modify('-1 day'))
                ->setUpdated(clone $date);
            $manager->persist($issue);
        }

        $manager->flush();
    }
}
