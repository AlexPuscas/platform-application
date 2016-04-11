<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="bugtracking_issue_types")
 * @Config
 */
class IssueType
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
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $description;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="type")
     */
    protected $issues;

    public function __construct()
    {
        $this->issues = new ArrayCollection();
    }

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
     * @return IssueType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return IssueType
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     *
     * @return IssueType
     */
    public function addIssues(Issue $issue)
    {
        $this->issues->add($issue);

        return $this;
    }

    /**
     * @param Issue $issue
     *
     * @return IssueType
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

