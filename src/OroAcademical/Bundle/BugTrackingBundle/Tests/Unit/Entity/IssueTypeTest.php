<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Unit;

use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType;

class IssueTypeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var IssueType
     */
    protected $target;

    public function setUp()
    {
        $this->target = new IssueType();
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
        $addMethod = 'add' . ucfirst($property);
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
        $addMethod = 'add' . ucfirst($property);
        $removeMethod = 'remove' . ucfirst($property);
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
        $expected = 'issueType';
        $this->target->setName($expected);
        $this->assertEquals($expected, (string)$this->target);
    }

    /**
     * @return array
     */
    public function adderRemoverDataProvider()
    {
        $issue = $this->getMock('OroAcademical\Bundle\BugTrackingBundle\Entity\Issue');

        return [
            ['issues', $issue],
        ];
    }

    /**
     * @return array
     */
    public function settersAndGettersDataProvider()
    {
        $issues = $this->getMock('Doctrine\Common\Collections\ArrayCollection');

        return [
            ['name', 'name'],
            ['description', 'description'],
            ['issues', $issues]
        ];
    }
}
