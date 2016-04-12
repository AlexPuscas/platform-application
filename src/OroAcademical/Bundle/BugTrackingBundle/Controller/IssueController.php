<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;

class IssueController extends Controller
{
    /**
     * @Route("/", name="bugtracking_issue_index")
     * @Template
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/view/{id}", name="bugtracking_issue_view", requirements={"id"="\d+"})
     * @Template()
     */
    public function viewAction(Issue $issue)
    {
        return ['entity' => $issue];
    }

    /**
     * @Route("/create", name="bugtracking_issue_create")
     * @Template("OroAcademicalBugTrackingBundle:Issue:update.html.twig")
     */
    public function createAction()
    {
        return $this->update();
    }

    /**
     * @Route("/update/{id}", name="bugtracking_issue_update", requirements={"id"="\d+"})
     * @Template()
     */
    public function updateAction(Issue $issue)
    {
        return $this->update($issue);
    }

    private function update(Issue $issue = null)
    {
        if (!$issue) {
            $issue = new Issue();
        }

        return $this->get('oro_form.model.update_handler')->handleUpdate(
            $issue,
            $this->get('oroacademical_bugtracking.form.issue'),
            function (Issue $issue) {
                return [
                    'route' => 'bugtracking_issue_update',
                    'parameters' => ['id' => $issue->getId()],
                ];
            },
            function (Issue $issue) {
                return [
                    'route' => 'bugtracking_issue_view',
                    'parameters' => ['id' => $issue->getId()],
                ];
            },
            $this->get('translator')->trans('bugtracking.issue.controller.issue_saved_message')
        );
    }
}
