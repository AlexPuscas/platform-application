<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;
use Symfony\Component\HttpFoundation\Request;

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
    public function createAction(Request $request)
    {
        return $this->update(new Issue(), $request);
    }

    /**
     * @Route("/update/{id}", name="bugtracking_issue_update", requirements={"id"="\d+"})
     * @Template()
     */
    public function updateAction(Issue $issue, Request $request)
    {
        return $this->update($issue, $request);
    }

    private function update(Issue $issue, Request $request)
    {
        return $this->get('oro_form.model.update_handler')->handleUpdate(
            $issue,
            $this->get('oroacademical_bugtracking.form.handler.issue.api')->getForm(),
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
            $this->get('translator')->trans('bugtracking.issue.controller.issue_saved_message'),
            $this->get('oroacademical_bugtracking.form.handler.issue.api')
        );
    }

    /**
     * This action is used to render the list of emails associated with the given entity
     * on the view page of this entity
     *
     * @Route(
     *      "/activity/view/{entityClass}/{entityId}",
     *      name="bugtracking_issue_activity_view"
     * )
     *
     * @Template
     */
    public function activityAction($entityClass, $entityId)
    {
        return array(
            'entity' => $this->get('oro_entity.routing_helper')->getEntity($entityClass, $entityId)
        );
    }
}
