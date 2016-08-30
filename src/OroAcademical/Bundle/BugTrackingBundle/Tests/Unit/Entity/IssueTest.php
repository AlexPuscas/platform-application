<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit;

use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;

class IssueTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Issue
     */
    protected $target;

    public function setUp()
    {
        $this->target = new Issue();
    }

    /**
     * @dataProvider settersAndGettersDataProvider
     * @param string $property
     * @param string $value
     */
    public function testSettersAndGetters($property, $value)
    {
        $method = 'set' . ucfirst($property);
        $result = $this->target->$method($value);

        $this->assertInstanceOf(get_class($this->target), $result);
        $this->assertEquals($value, $this->target->{'get' . $property}());
    }

    /**
     * @dataProvider adderRemoverDataProvider
     * @param string $property
     * @param string $value
     */
    public function testAdder($property, $value)
    {
        $addMethod = 'add' . ucfirst(substr($property, 0, -1));
        $getMethod = 'get' . ucfirst($property);
        $this->target->$addMethod();
        $actual = $this->target->$getMethod();
        $this->assertCount(0, $actual);
        $this->target->$addMethod($value);
        $actual = $this->target->$getMethod();
        $this->assertCount(1, $actual);
        $this->assertSame($value, $actual->get(0));
    }

    /**
     * @dataProvider adderRemoverDataProvider
     * @param string $property
     * @param string $value
     */
    public function testRemover($property, $value)
    {
        $addMethod = 'add' . ucfirst(substr($property, 0, -1));
        $removeMethod = 'remove' . ucfirst(substr($property, 0, -1));
        $getMethod = 'get' . ucfirst($property);
        $this->target->$addMethod($value);
        $this->target->$removeMethod(null);
        $this->target->$removeMethod();
        $actual = $this->target->$getMethod();
        $this->assertCount(1, $actual);
        $this->target->$removeMethod($value);
        $this->assertCount(0, $actual);
    }

    public function testToString()
    {
        $expected = 'issue';
        $this->target->setSummary($expected);
        $this->assertEquals($expected, (string)$this->target);
    }

    /**
     * @return array
     */
    public function settersAndGettersDataProvider()
    {
        $type = $this->getMock('OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType');
        $priority = $this->getMock('OroAcademical\Bundle\BugTrackingBundle\Entity\Priority');
        $resolution = $this->getMock('OroAcademical\Bundle\BugTrackingBundle\Entity\Resolution');
        $reporter = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $assignee = $this->getMock('Oro\Bundle\UserBundle\Entity\User');
        $relatedIssues = $this->getMock('Doctrine\Common\Collections\ArrayCollection');
        $collaborators = $this->getMock('Doctrine\Common\Collections\ArrayCollection');
        $parent = $this->getMock('OroAcademical\Bundle\BugTrackingBundle\Entity\Issue');
        $created = $this->getMock('\DateTime');
        $updated = $this->getMock('\DateTime');

        return [
            ['summary', 'summary'],
            ['code', 'code'],
            ['description', 'description'],
            ['status', 'status'],
            ['type', $type],
            ['priority', $priority],
            ['resolution', $resolution],
            ['reporter', $reporter],
            ['assignee', $assignee],
            ['relatedIssues', $relatedIssues],
            ['collaborators', $collaborators],
            ['parent', $parent],
            ['created', $created],
            ['updated', $updated],
        ];
    }

    /**
     * @return array
     */
    public function adderRemoverDataProvider()
    {
        $issue = $this->getMock('OroAcademical\Bundle\BugTrackingBundle\Entity\Issue');
        $collaborator = $this->getMock('Oro\Bundle\UserBundle\Entity\User');

        return [
            ['relatedIssues', $issue],
            ['collaborators', $collaborator],
        ];
    }
}
