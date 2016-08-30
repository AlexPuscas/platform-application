<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Common\Persistence\ObjectRepository;

use Oro\Bundle\NavigationBundle\Annotation\TitleTemplate;

use OroAcademical\Bundle\BugTrackingBundle\Entity\IssueType;
use OroAcademical\Bundle\BugTrackingBundle\Entity\Issue;

class IssueController extends Controller
{
    /**
     * @Route("/", name="bugtracking_issue_index")
     * @Template()
     * @TitleTemplate("View All")
     *
     * @return array
     */
    public function indexAction()
    {
        return [
            'entity_class' => $this->container->getParameter('oroacademical_bugtracking.issue.entity.class')
        ];
    }

    /**
     * @Route("/view/{id}", name="bugtracking_issue_view", requirements={"id"="\d+"})
     * @Template()
     * @TitleTemplate("View - Issues")
     *
     * @param Issue $issue
     * @return array
     */
    public function viewAction(Issue $issue)
    {
        $storyType = $this
            ->getRepository('OroAcademicalBugTrackingBundle:IssueType')
            ->findOneByName(IssueType::STORY_TYPE);

        return [
            'entity' => $issue,
            'storyType' => $storyType,
        ];
    }

    /**
     * @Route("/create/{id}", name="bugtracking_issue_create", requirements={"id"="\d+"}, defaults={"id" = null})
     * @Template("OroAcademicalBugTrackingBundle:Issue:update.html.twig")
     * @TitleTemplate("Create - Issues")
     *
     * @param Request $request
     * @param Issue|null $parent
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function createAction(Request $request, Issue $parent = null)
    {
        $issue = new Issue();
        if ($parent && $parent->getType()->getName() == IssueType::STORY_TYPE) {
            $subTaskType = $this
                ->getRepository('OroAcademicalBugTrackingBundle:IssueType')
                ->findOneByName(IssueType::SUB_TASK_TYPE);
            $issue->setParent($parent)->setType($subTaskType);
        }

        return $this->update($issue, $request);
    }

    /**
     * @Route("/update/{id}", name="bugtracking_issue_update", requirements={"id"="\d+"})
     * @Template()
     * @TitleTemplate("Edit - Issues")
     *
     * @param Request $request
     * @param Issue $issue
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function updateAction(Request $request, Issue $issue)
    {
        return $this->update($issue, $request);
    }

    /**
     * @param Issue $issue
     * @return array|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    private function update(Issue $issue)
    {
        return $this->get('oro_form.model.update_handler')->handleUpdate(
            $issue,
            $this->get('oroacademical_bugtracking.form.handler.issue')->getForm(),
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
            $this->get('oroacademical_bugtracking.form.handler.issue')
        );
    }

    /**
     * @param string $entityName
     * @return ObjectRepository
     */
    protected function getRepository($entityName)
    {
        return $this->getDoctrine()->getRepository($entityName);
    }
}
