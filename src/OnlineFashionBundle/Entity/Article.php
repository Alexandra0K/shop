<?php

namespace OnlineFashionBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * Article
 * @ORM\Table(name="articles")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\ArticleRepository")
 * @ExclusionPolicy("all")
 */
class Article
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Expose()
     */
    private $name;

    /**
     * @var double
     * @ORM\Column(name="basePrice", type="float")
     */
 private $basePrice;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     * @Expose()
     */
    private $dateAdded;

    /**
     * @var string
     * @Expose()
     */
    private $description;

    /**
     * @var int
     * @ORM\Column(name="author_id", type="integer")
     * @Expose()
     */
    private $authorId;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\User", inversedBy="articles")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * @Expose()
     *
     */
    private $author;

    /**
     * @var string
     * @ORM\Column(name="image", type="text", nullable=false)
     * @Expose()
     */
    private $image;

    /**
     * @var int
     * @ORM\Column(name="viewCount", type="integer")
     * @Expose()
     */
    private $viewCount;

    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Comment", mappedBy="article", cascade={"remove"})
     */
    private $comments;

    /**
     * @return ArrayCollection|Comment[]
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param Comment $comment
     * @return Article
     */
    public function addComment($comment=null)
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function __construct()
    {
        $this->dateAdded = new DateTime('now');
        $this->comments= new ArrayCollection();
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
     * Set title
     *
     * @param string $name
     *
     * @return Article
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Article
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }


    public function setDescription()
    {
        $this->description = substr($this->description, 0, strlen($this->description) / 2) . "...";
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        if (null === $this->description) {
            $this->setDescription();
        }
        return $this->description;
    }


    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     * @return Article
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
        return $this;
    }

    /**
     * @param User $author
     * @return Article
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return int
     */
    public function getViewCount()
    {
        return $this->viewCount;
    }

    /**
     * @param int $viewCount
     */
    public function setViewCount($viewCount)
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return float
     */
    public function getBasePrice()
    {
        return $this->basePrice;
    }

    /**
     * @param float $basePrice
     */
    public function setBasePrice($basePrice)
    {
        $this->basePrice = $basePrice;
    }
}

