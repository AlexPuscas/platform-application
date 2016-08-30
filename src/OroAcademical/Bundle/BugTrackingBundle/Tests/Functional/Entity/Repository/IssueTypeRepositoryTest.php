<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Functional\Entity\Repository;

use Doctrine\ORM\QueryBuilder;
use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Repository\IssueTypeRepository;

/**
 * @dbIsolation
 */
class IssueTypeRepositoryTest extends WebTestCase
{
    /**
     * @var IssueTypeRepository
     */
    protected $repository;

    protected function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());

        $this->repository = $this->getContainer()->get('doctrine')->getRepository(IssueType::class);
    }

    public function testGetIssuesByStatus()
    {
        $manager = $this->getContainer()->get('oro_entity.doctrine_helper')->getEntityManager(IssueType::class);

        $result = $this->repository->getWithoutTypeQueryBuilder(IssueType::BUG_TYPE);
        $this->assertInstanceOf(QueryBuilder::class, $result);
        $result = $result->getQuery()->getResult();
        $storyTypeCount = 0;
        foreach ($result as $type) {
            /** @var IssueType $type */

            $this->assertInstanceOf(IssueType::class, $type);
            $this->assertNotEquals(IssueType::BUG_TYPE, $type->getName());
            $storyTypeCount = $type->getName() == IssueType::STORY_TYPE ? ++$storyTypeCount : $storyTypeCount;
        }
        $this->assertEquals(1, $storyTypeCount);

        $result = $this->repository->getWithoutTypeQueryBuilder(IssueType::STORY_TYPE);
        $this->assertInstanceOf(QueryBuilder::class, $result);
        $result = $result->getQuery()->getResult();
        $bugTypeCount = 0;
        foreach ($result as $type) {
            /** @var IssueType $type */

            $this->assertInstanceOf(IssueType::class, $type);
            $this->assertNotEquals(IssueType::STORY_TYPE, $type->getName());
            $bugTypeCount = $type->getName() == IssueType::BUG_TYPE ? ++$bugTypeCount : $bugTypeCount;
        }
        $this->assertEquals(1, $bugTypeCount);
    }
}
