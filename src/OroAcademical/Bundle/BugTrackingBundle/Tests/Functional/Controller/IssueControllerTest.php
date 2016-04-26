<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Tests\Functional\Controller;

use Oro\Bundle\TestFrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * @dbIsolation
 */
class IssueControllerTest extends WebTestCase
{
    protected function setUp()
    {
        $this->initClient([], $this->generateBasicAuthHeader());
    }

    public function testCreate()
    {
        $crawler = $this->client->request('GET', $this->getUrl('bugtracking_issue_create'));
        $form = $crawler->selectButton('Save and Close')->form();
        $form['bugtracking_issue_form[summary]'] = 'Test Issue';
        $form['bugtracking_issue_form[code]'] = 'TI';
        $form['bugtracking_issue_form[description]'] = 'Test Issue Description';
        $form['bugtracking_issue_form[status]'] = 1;

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, Response::HTTP_OK);
        $this->assertContains("Issue saved", $crawler->html());
    }

    /**
     * @depends testCreate
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->getUrl('bugtracking_issue_index'));
        $response = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($response, Response::HTTP_OK);
        $this->assertContains('Test Issue', $response->getContent());
    }

    /**
     * @depends testCreate
     */
    public function testUpdate()
    {
        $response = $this->client->requestGrid(
            'bugtracking-issues-grid',
            ['bugtracking-issues-grid[_filter][condition][value]' => 'Test Issue']
        );

        $result = $this->getJsonResponseContent($response, Response::HTTP_OK);
        $result = reset($result['data']);

        $id = $result['id'];
        $crawler = $this->client->request(
            'GET',
            $this->getUrl('bugtracking_issue_update', array('id' => $result['id']))
        );

        $form = $crawler->selectButton('Save and Close')->form();
        $form['bugtracking_issue_form[description]'] = 'Updated description!';

        $this->client->followRedirects(true);
        $crawler = $this->client->submit($form);

        $result = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($result, Response::HTTP_OK);
        $this->assertContains("Issue saved", $crawler->html());

        return $id;
    }

    /**
     * @depends testUpdate
     */
    public function testView($id)
    {
        $crawler = $this->client->request(
            'GET',
            $this->getUrl('bugtracking_issue_view', array('id' => $id))
        );

        $response = $this->client->getResponse();
        $this->assertHtmlResponseStatusCodeEquals($response, Response::HTTP_OK);
        $this->assertContains(
            'Updated description!',
            $crawler->html()
        );
    }
}
