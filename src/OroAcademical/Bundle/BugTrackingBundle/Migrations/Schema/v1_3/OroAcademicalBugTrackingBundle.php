<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Schema\v1_3;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class OroAcademicalBugTrackingBundle implements Migration, ActivityExtensionAwareInterface
{
    /** @var ActivityExtension */
    protected $activityExtension;

    public function setActivityExtension(ActivityExtension $activityExtension)
    {
        $this->activityExtension = $activityExtension;
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        self::addActivityAssociations($schema, $this->activityExtension);
    }

    /**
     * Enables Email activity for User entity
     *
     * @param Schema            $schema
     * @param ActivityExtension $activityExtension
     */
    public static function addActivityAssociations(Schema $schema, ActivityExtension $activityExtension)
    {
        $activityExtension->addActivityAssociation($schema, 'bugtracking_issues', 'oro_user', true);
    }
}
