<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Functional\Api\Rest;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Priority;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Resolution;
use Symfony\Component\HttpFoundation\Response;

/**
* @dbIsolation
*/
class IssueControllerTest extends WebTestCase
{
    /**
     * @var array
     */
    protected $issueData = [
        'summary' => 'Test Issue',
        'code' => 'TI',
        'description' => 'Test Issue Description',
        'status' => 1,
    ];

    protected function setUp()
    {
        $this->initClient(array(), $this->generateWsseAuthHeader());
    }

    /**
     * @return array
     */
    public function testPost()
    {
        $request = ['bugtracking_issue_form' => $this->issueData];

        $this->client->request(
            'POST',
            $this->getUrl('bugtracking_issue_api_post_issue'),
            $request
        );

        $response = $this->getJsonResponseContent($this->client->getResponse(), Response::HTTP_CREATED);
        $this->assertArrayHasKey('id', $response);

        return $response['id'];
    }

    /**
     * @depends testPost
     * @param integer $id
     */
    public function testCget($id)
    {
        $this->client->request(
            'GET',
            $this->getUrl('bugtracking_issue_api_get_issues'),
            [],
            [],
            $this->generateWsseAuthHeader()
        );

        $issues = $this->getJsonResponseContent($this->client->getResponse(), Response::HTTP_OK);

        $this->assertCount(1, $issues);

        $this->assertArrayIntersectEquals(
            [
                'id' => $id,
                'summary' => $this->issueData['summary'],
                'code' => $this->issueData['code'],
                'description' => $this->issueData['description'],
                'status' => $this->issueData['status'],
            ],
            $issues[0]
        );

        $this->assertArrayHasKey('created', $issues[0]);
        $this->assertNotEmpty($issues[0]['created']);
        $this->assertArrayHasKey('updated', $issues[0]);
        $this->assertNotEmpty($issues[0]['updated']);
        $this->assertArrayHasKey('type', $issues[0]);
        $this->assertArrayHasKey('priority', $issues[0]);
        $this->assertArrayHasKey('resolution', $issues[0]);
    }

    /**
     * @depends testPost
     * @param integer $id
     * @return array
     */
    public function testGet($id)
    {
        $this->client->request(
            'GET',
            $this->getUrl('bugtracking_issue_api_get_issue', ['id' => $id]),
            [],
            [],
            $this->generateWsseAuthHeader()
        );

        $issue = $this->getJsonResponseContent($this->client->getResponse(), Response::HTTP_OK);

        $this->assertArrayIntersectEquals(
            [
                'id' => $id,
                'summary' => $this->issueData['summary'],
                'code' => $this->issueData['code'],
                'description' => $this->issueData['description'],
                'status' => $this->issueData['status'],
            ],
            $issue
        );

        $this->assertArrayHasKey('created', $issue);
        $this->assertNotEmpty($issue['created']);
        $this->assertArrayHasKey('updated', $issue);
        $this->assertNotEmpty($issue['updated']);
        $this->assertArrayHasKey('type', $issue);
        $this->assertArrayHasKey('priority', $issue);
        $this->assertArrayHasKey('resolution', $issue);

        $this->assertArrayHasKey('id', $issue);
        $this->assertGreaterThan(0, $issue['id']);

        return $issue;
    }

    /**
     * @param array $originalIssue
     * @depends testGet
     */
    public function testPut(array $originalIssue)
    {
        $id = $originalIssue['id'];

        $putData = [
            'summary' => 'Updated Test Issue',
            'code' => 'UTI',
            'description' => 'Updated Description',
            'status' => 2,
        ];

        $this->client->request(
            'PUT',
            $this->getUrl('bugtracking_issue_api_put_issue', ['id' => $id]),
            ['bugtracking_issue_form' => $putData],
            [],
            $this->generateWsseAuthHeader()
        );

        $result = $this->client->getResponse();
        $this->assertEmptyResponseStatusCodeEquals($result, Response::HTTP_NO_CONTENT);

        $this->client->request(
            'GET',
            $this->getUrl('bugtracking_issue_api_get_issue', ['id' => $id])
        );

        $updatedIssue = $this->getJsonResponseContent($this->client->getResponse(), Response::HTTP_OK);

        $expectedIssue = array_merge($originalIssue, $putData);
        unset($expectedIssue['updated']);

        $this->assertArrayIntersectEquals($expectedIssue, $updatedIssue);

        return $id;
    }

    /**
     * @param int $id
     * @depends testPut
     */
    public function testDelete($id)
    {
        $this->client->request(
            'DELETE',
            $this->getUrl('bugtracking_issue_api_delete_issue', ['id' => $id])
        );
        $result = $this->client->getResponse();

        $this->assertEmptyResponseStatusCodeEquals($result, Response::HTTP_NO_CONTENT);

        $this->client->request(
            'GET',
            $this->getUrl('bugtracking_issue_api_delete_issue', ['id' => $id])
        );
        $result = $this->client->getResponse();

        $this->assertJsonResponseStatusCodeEquals($result, Response::HTTP_NOT_FOUND);
    }
}
