<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity\Repository;

use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;

class IssueTypeRepository extends EntityRepository
{
    /**
     * @param $type
     * @return QueryBuilder
     */
    public function getWithoutTypeQueryBuilder($type)
    {
        $queryBuilder = $this->createQueryBuilder('issueType');

        return $queryBuilder
            ->where($queryBuilder->expr()->notLike('issueType.name', ':type'))
            ->setParameter('type', '%' . $type . '%');
    }
}
