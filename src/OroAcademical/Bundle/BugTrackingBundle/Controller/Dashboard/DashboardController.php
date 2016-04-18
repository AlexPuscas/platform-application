<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Controller\Dashboard;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DashboardController extends Controller
{
    /**
     * @Route(
     *     "/chart/issues-by-status/{widget}",
     *     name="bugtracking_issue_chart_by_status",
     *     requirements={"widget"="[\w-]+"}
     * )
     *
     * @Template("OroAcademicalBugTrackingBundle:Dashboard:issuesByStatus.html.twig")
     */
    public function issuesByStatusAction($widget)
    {
        $translator = $this->get('translator');
        $data = $this->getRepository('OroAcademicalBugTrackingBundle:Issue')->getIssuesByStatus();
        foreach ($data as &$issueData) {
            $issueData['status'] = $translator->trans(
                sprintf('bugtracking.dashboard.issue_chart_by_status.status.%d', $issueData['status'])
            );
        }

        $viewBuilder = $this->container->get('oro_chart.view_builder');
        $view = $viewBuilder
            ->setOptions(
                [
                    'name' => 'bar_chart',
                    'data_schema' => [
                        'label' => [
                            'field_name' => 'status',
                            'label' => 'bugtracking.dashboard.issue_chart_by_status.status.label',
                            'type' => 'string',
                        ],
                        'value' => [
                            'field_name' => 'numberOfIssues',
                            'label' => 'bugtracking.dashboard.issue_chart_by_status.numberOfIssues.label',
                            'type' => 'number',
                        ],
                    ]
                ]
            )
            ->setArrayData($data)
            ->getView();

        $widgetAttributes = $this->get('oro_dashboard.widget_configs')->getWidgetAttributesForTwig($widget);
        $widgetAttributes['chartView'] = $view;

        return $widgetAttributes;
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