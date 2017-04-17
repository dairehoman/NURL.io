<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Nurl
 *
 * @ORM\Table(name="nurl")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NurlRepository")
 */
class Nurl
{

    /**
     * Many Nurls have One Author.
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="nurls")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
     */
    private $author;


    /**
     * Many Nurls have Many Collections.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Collection")
     * @ORM\JoinTable(name="nurls_collections",
     *      joinColumns={@ORM\JoinColumn(name="nurl_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="collection_id", referencedColumnName="id")}
     *      )
     */
    private $collections;


    /**
     * Many Nurls have Many Tags.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag")
     * @ORM\JoinTable(name="nurls_tags",
     *      joinColumns={@ORM\JoinColumn(name="nurl_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="date_created", type="datetime", length=255)
     */
    private $dateCreated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_public", type="boolean")
     */
    private $isPublic;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_proposed_by_anonymous", type="boolean")
     */
    private $isProposedByAnonymous;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_reported_against", type="boolean")
     */
    private $isReportedAgainst = false;


    /**
     * @var string
     *
     * @ORM\Column(name="reported_against_reason", type="string",  length=255)
     */
    private $reportedAgainstReason = '';


    /**
     * @var string
     *
     * @ORM\Column(name="time_reported", type="datetime", length=255)
     */
    private $timeReported;

    /**
     * @var string
     *
     * @ORM\Column(name="email_of_reporter", type="string", length=255)
     */
    private $emailOfReporter = '';

    /**
     * @var string
     *
     * @ORM\Column(name="moderator_comments", type="string", length=255)
     */
    private $moderatorComments = '';

    /**
     * @var string
     *
     * @ORM\Column(name="date_last_edited", type="datetime", length=255)
     */
    private $dateLastEdited;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255)
     */
    private $link;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_votes", type="integer")
     */
    private $numVotes = -1;

    /**
     * @var string
     *
     * @ORM\Column(name="source", type="string", length=255)
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255)
     */
    private $note;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Nurl
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Nurl
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set source
     *
     * @param string $source
     *
     * @return Nurl
     */
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get source
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }


    /**
     * Set note
     *
     * @param string $note
     *
     * @return Nurl
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set author
     *
     * @param \AppBundle\Entity\User $author
     *
     * @return Nurl
     */
    public function setAuthor($author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return \AppBundle\Entity\User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->collections = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    /**
     * Add collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return Nurl
     */
    public function addCollection(Collection $collection)
    {
        $this->collections[] = $collection;

        return $this;
    }

    /**
     * Remove collection
     *
     * @param \AppBundle\Entity\Collection $collection
     */
    public function removeCollection(Collection $collection)
    {
        $this->collections->removeElement($collection);
    }

    /**
     * Get collections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollection()
    {
        return $this->collections;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Nurl
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Get collections
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCollections()
    {
        return $this->collections;
    }

    /**
     * Set dateLastEdited
     *
     * @param \DateTime $dateLastEdited
     *
     * @return Nurl
     */
    public function setDateLastEdited($dateLastEdited)
    {
        $this->dateLastEdited = $dateLastEdited;

        return $this;
    }

    /**
     * Get dateLastEdited
     *
     * @return string
     */
    public function getDateLastEdited()
    {
        return $this->dateLastEdited;
    }

    /**
     * Set isPublic
     *
     * @param boolean $isPublic
     *
     * @return Nurl
     */
    public function setIsPublic($isPublic)
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    /**
     * Get isPublic
     *
     * @return boolean
     */
    public function getIsPublic()
    {
        return $this->isPublic;
    }


    /**
     * Set numVotes
     *
     * @param integer $numVotes
     *
     * @return Nurl
     */
    public function setNumVotes($numVotes)
    {
        $this->numVotes = $numVotes;

        return $this;
    }

    /**
     * Get numVotes
     *
     * @return integer
     */
    public function getNumVotes()
    {
        return $this->numVotes;
    }

    /**
     * Set collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return Nurl
     */
    public function setCollection( $collection = null)
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * Set isReportedAgainst
     *
     * @param boolean $isReportedAgainst
     *
     * @return Nurl
     */
    public function setIsReportedAgainst($isReportedAgainst)
    {
        $this->isReportedAgainst = $isReportedAgainst;

        return $this;
    }

    /**
     * Get isReportedAgainst
     *
     * @return boolean
     */
    public function getIsReportedAgainst()
    {
        return $this->isReportedAgainst;
    }

    /**
     * Add tag
     *
     * @param \AppBundle\Entity\Tag $tag
     *
     * @return Nurl
     */
    public function addTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \AppBundle\Entity\Tag $tag
     */
    public function removeTag(\AppBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set reportedAgainstReason
     *
     * @param string $reportedAgainstReason
     *
     * @return Nurl
     */
    public function setReportedAgainstReason($reportedAgainstReason)
    {
        $this->reportedAgainstReason = $reportedAgainstReason;

        return $this;
    }

    /**
     * Get reportedAgainstReason
     *
     * @return string
     */
    public function getReportedAgainstReason()
    {
        return $this->reportedAgainstReason;
    }

    /**
     * Set timeReported
     *
     * @param \DateTime $timeReported
     *
     * @return Nurl
     */
    public function setTimeReported($timeReported)
    {
        $this->timeReported = $timeReported;

        return $this;
    }

    /**
     * Get timeReported
     *
     * @return string
     */
    public function getTimeReported()
    {
        return $this->timeReported;
    }

    /**
     * Set emailOfReporter
     *
     * @param string $emailOfReporter
     *
     * @return Nurl
     */
    public function setEmailOfReporter($emailOfReporter)
    {
        $this->emailOfReporter = $emailOfReporter;

        return $this;
    }

    /**
     * Get emailOfReporter
     *
     * @return string
     */
    public function getEmailOfReporter()
    {
        return $this->emailOfReporter;
    }

    /**
     * Set moderatorComments
     *
     * @param string $moderatorComments
     *
     * @return Nurl
     */
    public function setModeratorComments($moderatorComments)
    {
        $this->moderatorComments = $moderatorComments;

        return $this;
    }

    /**
     * Get moderatorComments
     *
     * @return string
     */
    public function getModeratorComments()
    {
        return $this->moderatorComments;
    }

    /**
     * Set isProposedByAnonymous
     *
     * @param boolean $isProposedByAnonymous
     *
     * @return Nurl
     */
    public function setIsProposedByAnonymous($isProposedByAnonymous)
    {
        $this->isProposedByAnonymous = $isProposedByAnonymous;

        return $this;
    }

    /**
     * Get isProposedByAnonymous
     *
     * @return boolean
     */
    public function getIsProposedByAnonymous()
    {
        return $this->isProposedByAnonymous;
    }
}
