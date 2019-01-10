<?php

namespace OnlineFashionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Security\Core\User\UserInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User implements UserInterface
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @Expose()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Expose()
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     * @Expose()
     */
    private $password;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Article", mappedBy="author")
     *@Expose()
     */
    private $articles;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\OrderArticle", mappedBy="author")
     *@Expose()
     */
    private $orderArticles;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Role", inversedBy="users")
     * @ORM\JoinTable(name="users_roles",
     * joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     *
     * @Expose()
     */
    private $roles;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255)
     * @Expose()
     *
     */
    private $fullName;

    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Comment", mappedBy="author", cascade={"remove"})
     */
    private $comments;
    /**
     * @var ArrayCollection|Message[]
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Message", mappedBy="sender")
     */
    private $senders;

    /**
     * @var ArrayCollection|Message[]
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Message", mappedBy="recipient")
     */
    private $recipients;

    /**
     * @return ArrayCollection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment|null $comment
     * @return User
     */
    public function addComment(Comment $comment=null)
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->orderArticles = new ArrayCollection();
        $this->roles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->recipients = new ArrayCollection();
        $this->senders = new ArrayCollection();
    }

    /**
     * @return ArrayCollection|Message[]
     */
    public function getSenders()
    {
        return $this->senders;
    }

    /**
     * @param Message $sender
     * @return User
     */
    public function setSenders(Message $sender)
    {
        $this->senders[] = $sender;
        return $this;
    }

    /**
     * @return ArrayCollection|Message[]
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @param Message $recipient
     * @return User
     */
    public function addRecipient(Message $recipient)
    {
        $this->recipients[] = $recipient;
        return $this;
    }


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
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
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
     * Set fullName
     *
     * @param string $fullName
     *
     * @return User
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return array (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $stringRoles = [];

        foreach ($this->roles as $role) {
            /** @var $role Role */
            $stringRoles[] = $role->getRole();
        }
        return $stringRoles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    /**
     * @return Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     * @return User
     */
    public function addPost(Article $article)
    {
        $this->articles[] = $article;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getOrderArticles()
    {
        return $this->orderArticles;
    }

    /**
     * @param OrderArticle $orderArticle
     * @return User
     */
    public function addOA(OrderArticle $orderArticle)
    {
        $this->orderArticles[] = $orderArticle;
        return $this;
    }

    /**
     * @param $role
     * @return User
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
        return $this;
    }

    /**
     * @param Article $article
     * @return bool
     */
    public function isAuthor(Article $article)
    {
        return $article->getAuthorId() === $this->getId();
    }

    /**
     * @param OrderArticle $orderArticle
     * @return bool
     */
    public function isAuthorOA(OrderArticle $orderArticle)
    {
        return $orderArticle->getAuthorId() === $this->getId();
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return in_array("ROLE_ADMIN", $this->getRoles());
    }
}

