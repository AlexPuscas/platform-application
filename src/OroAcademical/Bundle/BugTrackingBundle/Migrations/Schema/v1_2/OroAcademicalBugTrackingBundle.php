<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtension;
use Oro\Bundle\ActivityBundle\Migration\Extension\ActivityExtensionAwareInterface;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtension;
use Oro\Bundle\EntityExtendBundle\Migration\Extension\ExtendExtensionAwareInterface;
use Oro\Bundle\EntityExtendBundle\Tools\ExtendDbIdentifierNameGenerator;
use Oro\Bundle\MigrationBundle\Migration\Extension\NameGeneratorAwareInterface;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use Oro\Bundle\MigrationBundle\Tools\DbIdentifierNameGenerator;

class OroAcademicalBugTrackingBundle implements
    Migration,
    NameGeneratorAwareInterface,
    ExtendExtensionAwareInterface,
    ActivityExtensionAwareInterface
{
    /** @var ActivityExtension */
    protected $activityExtension;

    /**
     * @var ExtendDbIdentifierNameGenerator
     */
    protected $nameGenerator;

    /**
     * @var ExtendExtension
     */
    protected $extendExtension;

    public function setActivityExtension(ActivityExtension $activityExtension)
    {
        // TODO: Implement setActivityExtension() method.
    }

    public function setExtendExtension(ExtendExtension $extendExtension)
    {
        // TODO: Implement setExtendExtension() method.
    }

    public function up(Schema $schema, QueryBag $queries)
    {
        // TODO: Implement up() method.
    }

    public function setNameGenerator(DbIdentifierNameGenerator $nameGenerator)
    {
        // TODO: Implement setNameGenerator() method.
    }

}
