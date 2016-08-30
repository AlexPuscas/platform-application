<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Functional\Entity\Repository;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;

use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Repository\IssueRepository;

/**
 * @dbIsolation
 */
class IssueRepositoryTest extends WebTestCase
{
    /**
     * @var IssueRepository
     */
    protected $repository;

    protected function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());

        $this->repository = $this->getContainer()->get('doctrine')->getRepository(Issue::class);
    }

    public function testGetIssuesByStatus()
    {
        $this->assertEmpty($this->repository->getIssuesByStatus());

        $manager = $this->getContainer()->get('oro_entity.doctrine_helper')->getEntityManager(Issue::class);

        $issue = new Issue();
        $issue->setSummary('test1')->setCode('test')->setStatus(1);
        $manager->persist($issue);
        $issue = new Issue();
        $issue->setSummary('test2')->setCode('test')->setStatus(1);
        $manager->persist($issue);
        $issue = new Issue();
        $issue->setSummary('test3')->setCode('test')->setStatus(2);
        $manager->persist($issue);
        $manager->flush();

        $expected = [
            ['status' => 1, 'numberOfIssues' => 2],
            ['status' => 2, 'numberOfIssues' => 1],
        ];
        $result = $this->repository->getIssuesByStatus();

        $this->assertEquals($expected, $result);
    }
}
