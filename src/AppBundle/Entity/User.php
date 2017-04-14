<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nurls = new ArrayCollection();
        $this->collections = new ArrayCollection();
        $this->isActive = true;
    }

    /**
     * One User has Many Nurls.
     * @ORM\OneToMany(targetEntity="Nurl", mappedBy="author")
     */
    private $nurls;

    /**
     * One User has Many Collections.
     * @ORM\OneToMany(targetEntity="Collection", mappedBy="author")
     */
    private $collections;

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
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;


    /**
     * @ORM\Column(type="json_array")
     */
    private $roles = [];


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
     * Add nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     *
     * @return User
     */
    public function addNurl(Nurl $nurl)
    {
        $this->nurls[] = $nurl;

        return $this;
    }

    /**
     * Remove nurl
     *
     * @param \AppBundle\Entity\Nurl $nurl
     */
    public function removeNurl(Nurl $nurl)
    {
        $this->nurls->removeElement($nurl);
    }

    /**
     * Get nurls
     *
     * @return ArrayCollection
     */
    public function getNurls()
    {
        return $this->nurls;
    }

    //---------------------------------------------

    public function getRoles()
    {
        $roles = $this->roles;
        return $roles;
    }

    public function getSalt()
    {

    }

    public function eraseCredentials()
    {

    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array( $this->id,
            $this->username, $this->password,
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->username,
            $this->password
            ) = unserialize($serialized);
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return User
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Add collection
     *
     * @param \AppBundle\Entity\Collection $collection
     *
     * @return User
     */
    public function addCollection(\AppBundle\Entity\Collection $collection)
    {
        $this->collections[] = $collection;

        return $this;
    }

    /**
     * Remove collection
     *
     * @param \AppBundle\Entity\Collection $collection
     */
    public function removeCollection(\AppBundle\Entity\Collection $collection)
    {
        $this->collections->removeElement($collection);
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
}
