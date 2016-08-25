<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Data\ORM;

use Doctrine\Common\Persistence\ObjectManager;

use Oro\Bundle\DashboardBundle\Migrations\Data\ORM\AbstractDashboardFixture;

use OroAcademical\Bundle\BugTrackingBundle\Entity\Resolution;

class LoadResolutions extends AbstractDashboardFixture
{
    /** @var array */
    protected $resolutionNames = [
        Resolution::CANNOT_REPRODUCE_RESOLUTION,
        Resolution::DUPLICATED_RESOLUTION,
        Resolution::FIXED_RESOLUTION,
        Resolution::INVALID_RESOLUTION,
    ];

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        foreach ($this->resolutionNames as $index => $resolutionName) {
            $resolution = new Resolution();
            $resolution->setName($resolutionName);

            $manager->persist($resolution);
            $manager->flush();
        }
    }
}
