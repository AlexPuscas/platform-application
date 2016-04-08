<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
