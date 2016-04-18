<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;
use Oro\Bundle\UserBundle\Entity\User;
use OroAcademical\Bundle\BugTrackingBundle\Model\ExtendIssue;

/**
 * @ORM\Entity(repositoryClass="OroAcademical\Bundle\BugTrackingBundle\Repository\IssueRepository")
 * @ORM\Table(name="bugtracking_issues")
 * @Config(
 *     defaultValues={
 *          "tag"={
 *              "enabled"=true
 *          },
 *     }
 * )
 */
class Issue extends ExtendIssue
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
    protected $summary;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $code;

    /**
     * @var string
     *
     * @ORM\Column(type="text", type="text", nullable=true)
     */
    protected $description;

    /**
     * @var IssueType
     *
     * @ORM\ManyToOne(targetEntity="IssueType", inversedBy="issues")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $type;

    /**
     * @var Priority
     *
     * @ORM\ManyToOne(targetEntity="Priority", inversedBy="issues")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $priority;

    /**
     * @var Resolution
     *
     * @ORM\ManyToOne(targetEntity="Resolution", inversedBy="issues")
     * @ORM\JoinColumn(name="resolution_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $resolution;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", nullable=true, options={"default":1})
     */
    protected $status;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="reporter_user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $reporter;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assignee_user_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $assignee;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="OroAcademical\Bundle\BugTrackingBundle\Entity\Issue", mappedBy="parent", orphanRemoval=true)
     */
    protected $relatedIssues;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinTable(name="bugtr_issues_to_oro_user_user",
     *      joinColumns={@ORM\JoinColumn(name="issue_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="issue_collaborator_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $collaborators;

    /**
     * @var Issue|null
     *
     * @ORM\ManyToOne(targetEntity="Issue", inversedBy="relatedIssues")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $parent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $created;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime")
     */
    protected $updated;

    public static function getStatusName($status)
    {
        switch ($status) {
            case 1:
                return 'Open';
                break;
            case 2 :
                return 'In Progress';
                break;
            case 3:
                return 'Closed';
                break;
            case 4:
                return 'Resolved';
                break;
            case 5:
                return 'Reopened';
                break;
            default:
                return 'Undefined';
        }
    }

    public function __construct()
    {
        parent::__construct();

        $this->relatedIssues = new ArrayCollection();
        $this->collaborators = new ArrayCollection();
        $this->created = $this->updated = new \DateTime();
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
    public function getSummary()
    {
        return $this->summary;
    }

    /**
     * @param string $summary
     * @return Issue
     */
    public function setSummary($summary)
    {
        $this->summary = $summary;

        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return Issue
     */
    public function setCode($code)
    {
        $this->code = $code;

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
     * @return Issue
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return IssueType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param IssueType $type
     * @return Issue
     */
    public function setType(IssueType $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param Priority $priority
     * @return Issue
     */
    public function setPriority(Priority $priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return Resolution
     */
    public function getResolution()
    {
        return $this->resolution;
    }

    /**
     * @param Resolution $resolution
     * @return Issue
     */
    public function setResolution(Resolution $resolution)
    {
        $this->resolution = $resolution;

        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return Issue
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return User
     */
    public function getReporter()
    {
        return $this->reporter;
    }

    /**
     * @param User $reporter
     * @return Issue
     */
    public function setReporter(User $reporter)
    {
        $this->reporter = $reporter;

        return $this;
    }

    /**
     * @return User
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @param User $assignee
     * @return Issue
     */
    public function setAssignee(User $assignee)
    {
        $this->assignee = $assignee;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getRelatedIssues()
    {
        return $this->relatedIssues;
    }

    /**
     * @param Issue $relatedIssue
     * @return Issue
     */
    public function addRelatedIssue(Issue $relatedIssue)
    {
        $this->relatedIssues->add($relatedIssue);

        return $this;
    }

    /**
     * @param Issue $relatedIssue
     * @return Issue
     */
    public function removeRelatedIssue(Issue $relatedIssue)
    {
        $this->relatedIssues->removeElement($relatedIssue);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getCollaborators()
    {
        return $this->collaborators;
    }

    /**
     * @param User $collaborator
     * @return Issue
     */
    public function addCollaborator(User $collaborator)
    {
        $this->collaborators->add($collaborator);

        return $this;
    }

    /**
     * @param User $collaborator
     * @return Issue
     */
    public function removeCollaborator(User $collaborator)
    {
        $this->collaborators->removeElement($collaborator);

        return $this;
    }

    /**
     * @return null|Issue
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param null|Issue $parent
     * @return Issue
     */
    public function setParent($parent)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     * @return Issue
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Issue
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    function __toString()
    {
        return $this->getSummary();
    }
}
