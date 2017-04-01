<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Moderator
 *
 * @ORM\Table(name="moderator")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ModeratorRepository")
 */
class Moderator
{
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
     * @ORM\Column(name="username", type="string", length=255)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=255)
     */
    private $role;

    /**
     * @var string
     *
     * @ORM\Column(name="profilePic", type="string", length=255)
     */
    private $profilePic;

    /**
     * @var int
     *
     * @ORM\Column(name="numNurlsCreated", type="integer")
     */
    private $numNurlsCreated;

    /**
     * @var int
     *
     * @ORM\Column(name="numNotesCreated", type="integer")
     */
    private $numNotesCreated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateMemberSince", type="date")
     */
    private $dateMemberSince;

    /**
     * @var string
     *
     * @ORM\Column(name="bio", type="string", length=255)
     */
    private $bio;

    /**
     * @var string
     *
     * @ORM\Column(name="college", type="string", length=255)
     */
    private $college;

    /**
     * @var string
     *
     * @ORM\Column(name="company", type="string", length=255)
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(name="interests", type="string", length=255)
     */
    private $interests;

    /**
     * @var bool
     *
     * @ORM\Column(name="isPrivate", type="boolean")
     */
    private $isPrivate;


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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set profilePic
     *
     * @param string $profilePic
     *
     * @return User
     */
    public function setProfilePic($profilePic)
    {
        $this->profilePic = $profilePic;

        return $this;
    }

    /**
     * Get profilePic
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->profilePic;
    }

    /**
     * Set numNurlsCreated
     *
     * @param integer $numNurlsCreated
     *
     * @return User
     */
    public function setNumNurlsCreated($numNurlsCreated)
    {
        $this->numNurlsCreated = $numNurlsCreated;

        return $this;
    }

    /**
     * Get numNurlsCreated
     *
     * @return int
     */
    public function getNumNurlsCreated()
    {
        return $this->numNurlsCreated;
    }

    /**
     * Set numNotesCreated
     *
     * @param integer $numNotesCreated
     *
     * @return User
     */
    public function setNumNotesCreated($numNotesCreated)
    {
        $this->numNotesCreated = $numNotesCreated;

        return $this;
    }

    /**
     * Get numNotesCreated
     *
     * @return int
     */
    public function getNumNotesCreated()
    {
        return $this->numNotesCreated;
    }

    /**
     * Set dateMemberSince
     *
     * @param \DateTime $dateMemberSince
     *
     * @return User
     */
    public function setDateMemberSince($dateMemberSince)
    {
        $this->dateMemberSince = $dateMemberSince;

        return $this;
    }

    /**
     * Get dateMemberSince
     *
     * @return \DateTime
     */
    public function getDateMemberSince()
    {
        return $this->dateMemberSince;
    }

    /**
     * Set bio
     *
     * @param string $bio
     *
     * @return User
     */
    public function setBio($bio)
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get bio
     *
     * @return string
     */
    public function getBio()
    {
        return $this->bio;
    }

    /**
     * Set college
     *
     * @param string $college
     *
     * @return User
     */
    public function setCollege($college)
    {
        $this->college = $college;

        return $this;
    }

    /**
     * Get college
     *
     * @return string
     */
    public function getCollege()
    {
        return $this->college;
    }

    /**
     * Set company
     *
     * @param string $company
     *
     * @return User
     */
    public function setCompany($company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set interests
     *
     * @param string $interests
     *
     * @return User
     */
    public function setInterests($interests)
    {
        $this->interests = $interests;

        return $this;
    }

    /**
     * Get interests
     *
     * @return string
     */
    public function getInterests()
    {
        return $this->interests;
    }

    /**
     * Set isPrivate
     *
     * @param boolean $isPrivate
     *
     * @return User
     */
    public function setIsPrivate($isPrivate)
    {
        $this->isPrivate = $isPrivate;

        return $this;
    }

    /**
     * Get isPrivate
     *
     * @return bool
     */
    public function getIsPrivate()
    {
        return $this->isPrivate;
    }
}

