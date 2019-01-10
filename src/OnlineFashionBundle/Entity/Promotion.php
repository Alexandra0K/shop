<?php

namespace OnlineFashionBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\PromotionRepository")
 */
class Promotion
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
     * @var \DateTime
     *
     * @ORM\Column(name="validFrom", type="datetime")
     */
    private $validFrom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="validTo", type="datetime")
     */
    private $validTo;

    /**
     * @var int
     *
     * @ORM\Column(name="weight", type="integer")
     */
    private $weight;

    /**
     * @var float
     *
     * @ORM\Column(name="reduction", type="decimal", precision=10, scale=2)
     */
    private $reduction;

    /**
     * @var float
     *
     * @ORM\Column(name="promoPrice", type="decimal", precision=10, scale=2)
     */
    private $promoPrice;

    /**
     * @var Article[]
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Article", inversedBy="promotions")
     */
    private $articles;

    /**
     * @var Article
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Article", mappedBy="promotion")
     */
    private $article;

    /**
     * @var Category
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Category", mappedBy="promotion")
     */
    private $category;

    /**
     * @var Category[]
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Category", inversedBy="promotions")
     */
    private $categories;

    public function __construct()
    {
        $this->validFrom = new DateTime();
        $this->validTo = new DateTime();
        $this->articles = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }
    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set validFrom.
     *
     * @param \DateTime $validFrom
     *
     * @return Promotion
     */
    public function setValidFrom($validFrom)
    {
        $this->validFrom = $validFrom;

        return $this;
    }

    /**
     * Get validFrom.
     *
     * @return \DateTime
     */
    public function getValidFrom()
    {
        return $this->validFrom;
    }

    /**
     * Set validTo.
     *
     * @param \DateTime $validTo
     *
     * @return Promotion
     */
    public function setValidTo($validTo)
    {
        $this->validTo = $validTo;

        return $this;
    }

    /**
     * Get validTo.
     *
     * @return \DateTime
     */
    public function getValidTo()
    {
        return $this->validTo;
    }

    /**
     * Set weight.
     *
     * @param int $weight
     *
     * @return Promotion
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set promoPrice.
     *
     */
    public function setPromoPrice()
    {
        $this->promoPrice = floatval(1 - ($this->reduction * ($this->article->getBasePrice())));

    }

    /**
     * Get promoPrice.
     *
     * @return string
     */
    public function getPromoPrice()
    {
        return $this->promoPrice;
    }



    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article $article
     */
    public function addArticle($article)
    {
        $this->articles[] = $article;
    }

    /**
     * @return string
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * @param string $reduction
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;
    }

    /**
     * @return Category[]
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     */
    public function setCategories($category)
    {
        $this->categories[] = $category;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Promotion
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }
}
