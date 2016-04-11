<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;

/**
 * @ORM\Entity()
 * @ORM\Table(name="bugtracking_resolutions")
 * @Config
 */
class Resolution
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="resolution")
     */
    protected $issues;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Resolution
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getIssues()
    {
        return $this->issues;
    }

    /**
     * @param Issue $issue
     * @return Resolution
     */
    public function addIssues(Issue $issue)
    {
        $this->issues->add($issue);

        return $this;
    }

    /**
     * @param Issue $issue
     * @return Resolution
     */
    public function removeIssues(Issue $issue)
    {
        $this->issues->removeElement($issue);

        return $this;
    }

    function __toString()
    {
        return $this->getName();
    }
}
