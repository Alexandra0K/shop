<?php

namespace OnlineFashionBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
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
     * @var double
     * @ORM\Column(name="promoPrice", type="float")
     * @ORM\OneToOne(targetEntity="OnlineFashionBundle\Entity\Promotion", mappedBy="promoPrice")
     */
    private $promoPrice;

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
    private $summary;

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
     * @var Category[]
     *
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Category", inversedBy="articles", cascade={"remove"})
     * @ORM\JoinTable(name="article_category")
     */
    private $categories;


    /**
     * @var Promotion[]
     *
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Promotion", inversedBy="articles", cascade={"remove"})
     * @ORM\JoinTable(name="article_promotion")
     */
    private $promotions;

    /**
     * @var Promotion
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\Promotion", inversedBy="article")
     *
     */
    private $promotion;

    /**
     * @var Category
     */
    private $category;

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
     * @var string
     * @ORM\Column(name="description", type="text")
     * @Expose()
     */
private $description;

    /**
     * @var ArrayCollection|Comment[]
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Comment", mappedBy="article", cascade={"remove"})
     */
    private $comments;


//    /**
//     * @var PurchaseItem[]
//     * @ORM\OneToMany(targetEntity="PurchaseItem", mappedBy="article", cascade={"remove"})
//     */
//    private $purchasedItems;

    /**
     * Article constructor.
     */
    public function __construct()
    {
        $this->dateAdded = new DateTime('now');
        $this->comments= new ArrayCollection();
        $this->categories= new ArrayCollection();
        $this->promotions= new ArrayCollection();
    }

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
     *
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

    public function setSummary()
    {
        $this->summary = substr($this->description, 0, strlen($this->description) / 2) . "...";
    }

    /**
     * @return string
     */
    public function getSummary()
    {
        if (null === $this->summary) {
            $this->setSummary();
        }
        return $this->summary;
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


    /**
     * @param Category $category
     */
    public function addCategory($category)
    {
        if ($this->categories->contains($category)) {
            return;
        }
        $this->categories->add($category);
        $category->addArticle($this);
    }
    /**
     * @param Category $category
     */
    public function removeCategory($category)
    {
        if (!$this->categories->contains($category)) {
            return;
        }
        $this->categories->removeElement($category);
        $category->removeArticle($this);
    }

    /**
     *  @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category[] $categories
     */
    public function setCategories($categories)
    {
        foreach ($categories as $category) {
            $this->removeCategory($category);
        }
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
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
     * @return Article
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->categories[] = $category;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @return Promotion[]
     */
    public function getPromotions()
    {
        return $this->promotions;
    }

    /**
     * @param Promotion $promotion
     */
    public function setPromotions($promotion)
    {
        $this->promotions[] = $promotion;
    }

    /**
     * @return Promotion
     */
    public function getPromotion()
    {
        return $this->promotion;
    }

    /**
     * @param Promotion $promotion
     */
    public function setPromotion($promotion)
    {
        $this->promotion = $promotion;
    }

    /**
     * @return float
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }

    /**
     * @param float $promoPrice
     * @return Article
     */
    public function setPromoPrice($promoPrice)
    {
        $this->promoPrice = $promoPrice;
        return $this;
    }


}

