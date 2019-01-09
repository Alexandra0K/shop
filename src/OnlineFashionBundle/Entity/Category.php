<?php

namespace OnlineFashionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\OneToMany;


/**
 * Category
 *
 * @ORM\Table(name="categories")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * @var Category
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id", nullable=true)
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="catName", type="string", length=255)
     */
    private $catName;

    /**
     * @var Article[]
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Article", mappedBy="categories")
     */
    private $articles;

    /**
     * @var Promotion[]
     * @ORM\ManyToMany(targetEntity="OnlineFashionBundle\Entity\Promotion", mappedBy="categories")
     * @ORM\JoinTable(name="category_promotion")
     */
    private $promotions;

    /**
     * @var Promotion
     * @ManyToOne(targetEntity="OnlineFashionBundle\Entity\Promotion", inversedBy="category")
     */
    private $promotion;

    public function __construct() {

        $this->children = new ArrayCollection();
        $this->articles = new ArrayCollection();
        $this->promotions = new ArrayCollection();
    }


    /**
     * @return Article[]
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param Article[] $articles
     */
    public function setArticles($articles)
    {
        $this->articles->clear();
        $this->articles = new ArrayCollection($articles);
    }



    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return Category
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return string
     */
    public function getCatName()
    {
        return $this->catName;
    }

    /**
     * @param string $catName
     */
    public function setCatName($catName)
    {
        $this->catName = $catName;
    }


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param Article $article
     */
    public function addArticle($article)
    {
        if ($this->articles->contains($article)) {
            return;
        }
        $this->articles->add($article);
        $article->addCategory($this);
    }
    /**
     * @param Article $article
     */
    public function removeArticle($article)
    {
        if (!$this->articles->contains($article)) {
            return;
        }
        $this->articles->removeElement($article);
        $article->removeCategory($this);
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
    public function addPromotion($promotion)
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


}
