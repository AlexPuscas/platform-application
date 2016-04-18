<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Repository;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{
    public function getIssuesByStatus()
    {
        return $this
            ->createQueryBuilder('issue')
            ->select('issue.status as status, COUNT(issue.id) as numberOfIssues')
            ->groupBy('issue.status')
            ->getQuery()
            ->getResult();
    }
}
