<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit\Form\Type;

use OroAcademical\Bundle\BugTrackingBundle\Form\Type\IssueType;

class IssueTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueType
     */
    protected $issueType;

    protected function setUp()
    {
        $this->issueType = new IssueType();
    }

    public function testGetName()
    {
        $this->assertEquals('bugtracking_issue', $this->issueType->getName());
    }

    public function testSetDefaultOptions()
    {
        $resolver = $this->getMock('Symfony\Component\OptionsResolver\OptionsResolver');
        $resolver
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->isType('array'));
        $this->issueType->setDefaultOptions($resolver);
    }

    /**
     * @dataProvider testBuildFormDataProvider
     * @param array $expectedFields
     */
    public function testBuildForm(array $expectedFields)
    {
        $builder = $this->getMockBuilder('Symfony\Component\Form\FormBuilder')->disableOriginalConstructor()->getMock();
        $order = 0;
        foreach ($expectedFields as $fieldName => $formType) {
            $builder
                ->expects($this->at($order++))
                ->method('add')
                ->with($fieldName, $formType, $this->isType('array'))
                ->will($this->returnSelf());
        }

        $this->issueType->buildForm($builder, []);
    }

    /**
     * @return array
     */
    public function testBuildFormDataProvider()
    {
        return [
            [
                [
                    'summary' => 'text',
                    'code' => 'text',
                    'description' => 'text',
                    'type' => 'entity',
                    'priority' => 'entity',
                    'resolution' => 'entity',
                    'status' => 'choice',
                    'reporter' => 'entity',
                    'assignee' => 'entity',
                ]
            ]
        ];
    }
}
