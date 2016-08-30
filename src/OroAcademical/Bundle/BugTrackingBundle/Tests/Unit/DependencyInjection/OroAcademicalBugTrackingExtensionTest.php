<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit\DependencyInjection;

use Oro\Bundle\TestFrameworkBundle\Test\DependencyInjection\ExtensionTestCase;

use OroAcademical\Bundle\BugTrackingBundle\DependencyInjection\OroAcademicalBugTrackingExtension;

class OroAcademicalBugTrackingExtensionTest extends ExtensionTestCase
{
    public function testLoad()
    {
        $this->loadExtension(new OroAcademicalBugTrackingExtension());

        $expectedParameters = [
            'oroacademical_bugtracking.issue.entity.class',
            'oroacademical_bugtracking.form.type.issue.class',
            'oroacademical_bugtracking.form.type.issue.api.class',
            'oroacademical_bugtracking.form.handler.issue.class',
            'oroacademical_bugtracking.issue.manager.api.class',
        ];
        $this->assertParametersLoaded($expectedParameters);

        $expectedDefinitions = [
            'oroacademical_bugtracking.issue.manager.api',
            'oroacademical_bugtracking.form.type.issue',
            'oroacademical_bugtracking.form.type.api.issue',
            'oroacademical_bugtracking.form.issue',
            'oroacademical_bugtracking.form.issue.api',
            'oroacademical_bugtracking.form.handler.issue',
            'oroacademical_bugtracking.form.handler.issue.api',
            'oroacademical_bugtracking.importexport.data_converter.issue',
            'oroacademical_bugtracking.importexport.processor.export',
            'oroacademical_bugtracking.importexport.strategy.isue.add_or_replace',
            'oroacademical_bugtracking.importexport.processor.add_or_replace',
        ];
        $this->assertDefinitionsLoaded($expectedDefinitions);
    }
}
