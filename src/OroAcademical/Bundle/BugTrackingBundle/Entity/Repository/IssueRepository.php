<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class IssueRepository extends EntityRepository
{
    /**
     * @return array
     */
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
