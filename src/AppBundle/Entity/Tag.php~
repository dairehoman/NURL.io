<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Tag
 *
 * @ORM\Table(name="tag")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TagRepository")
 */
class Tag
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nurls = new ArrayCollection();
    }

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
     * @ORM\Column(name="tag_value", type="string", length=255)
     */
    private $tagvalue;

    /**
     * @var integer
     *
     * @ORM\Column(name="num_votes", type="integer")
     */
    private $numVotes = -1;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_proposed", type="boolean")
     */
    private $isProposed;

    /**
     * Many Tags have Many NURLS.
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Nurl")
     * @ORM\JoinTable(name="tags_nurls",
     *      joinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="nurl_id", referencedColumnName="id")}
     *      )
     */
    private $nurls;

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
     * Set tagvalue
     *
     * @param string $tagvalue
     *
     * @return Tag
     */
    public function setTagvalue($tagvalue)
    {
        $this->tagvalue = $tagvalue;

        return $this;
    }

    /**
     * Get tagvalue
     *
     * @return string
     */
    public function getTagvalue()
    {
        return $this->tagvalue;
    }

    /**
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return Tag
     */
    public function addNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurls[] = $nurl;

        return $this;
    }

    /**
     * Remove nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     */
    public function removeNurl(\AppBundle\Entity\Nurl $nurl)
    {
        $this->nurls->removeElement($nurl);
    }

    /**
     * Get nurls
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNurls()
    {
        return $this->nurls;
    }

    /**
     * Set isProposed
     *
     * @param boolean $isProposed
     *
     * @return Tag
     */
    public function setIsProposed($isProposed)
    {
        $this->isProposed = $isProposed;

        return $this;
    }

    /**
     * Get isProposed
     *
     * @return boolean
     */
    public function getIsProposed()
    {
        return $this->isProposed;
    }

    /**
     * Set numVotes
     *
     * @param integer $numVotes
     *
     * @return Tag
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
}
