<?php

namespace OroAcademical\Bundle\BugTrackingBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * @ORM\Entity()
 * @ORM\Table(name="bugtracking_resolutions")
 * @Config()
 */
class Resolution
{
    const FIXED_RESOLUTION = 'Fixed';
    const DUPLICATED_RESOLUTION = 'Duplicated';
    const CANNOT_REPRODUCE_RESOLUTION = 'Cannot Reproduce';
    const INVALID_RESOLUTION = 'Invalid';

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "identity"=true,
     *              "order"=10
     *          }
     *      }
     * )
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     *
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "order"=20
     *          }
     *      }
     * )
     */
    protected $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(targetEntity="Issue", mappedBy="resolution")
     *
     * ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
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
     * @param Collection $issues
     * @return Collection
     */
    public function setIssues(Collection $issues)
    {
        $this->issues = $issues;

        return $this;
    }

    /**
     * @param Issue $issue
     * @return Resolution
     */
    public function addIssues(Issue $issue = null)
    {
        if ($issue && !$this->issues->contains($issue)) {
            $this->issues->add($issue);
        }

        return $this;
    }

    /**
     * @param Issue $issue
     * @return Resolution
     */
    public function removeIssues(Issue $issue = null)
    {
        $this->issues->removeElement($issue);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getName();
    }
}
