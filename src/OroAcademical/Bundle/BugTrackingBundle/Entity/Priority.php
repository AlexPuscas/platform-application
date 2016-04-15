<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;

/**
 * @ORM\Entity()
 * @ORM\Table(name="bugtracking_priorities")
 * @Config
 */
class Priority
{
    const BLOCKER_PRIORITY = 'Blocker';
    const CRITICAL_PRIORITY = 'Critical';
    const MAJOR_PRIORITY = 'Major';
    const TRIVIAL_PRIORITY = 'Trivial';

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
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $priority;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="priority")
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
     * @return Priority
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
     * @return Priority
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return Priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

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
     * @return Priority
     */
    public function addIssues(Issue $issue)
    {
        $this->issues->add($issue);

        return $this;
    }

    /**
     * @param Issue $issue
     * @return Priority
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
