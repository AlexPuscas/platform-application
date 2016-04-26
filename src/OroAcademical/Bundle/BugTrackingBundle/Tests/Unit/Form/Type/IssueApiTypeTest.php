<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit\Form\Type;

use OroAcademical\Bundle\BugTrackingBundle\Form\Type\IssueApiType;

class IssueApiTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueApiType
     */
    protected $issueType;

    protected function setUp()
    {
        $this->issueType = new IssueApiType();
    }

    public function testGetName()
    {
        $this->assertEquals('bugtracking_issue_api', $this->issueType->getName());
    }

    public function testGetParent()
    {
        $this->assertEquals('bugtracking_issue', $this->issueType->getParent());
    }

    public function testConfigureOptions()
    {
        $resolver = $this->getMock('Symfony\Component\OptionsResolver\OptionsResolver');
        $resolver
            ->expects($this->once())
            ->method('setDefaults')
            ->with($this->isType('array'));
        $this->issueType->setDefaultOptions($resolver);
    }
}
