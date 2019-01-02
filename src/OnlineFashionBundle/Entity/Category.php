<?php

namespace OnlineFashionBundle\Entity;

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
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * One Category has Many Categories.
     * @OneToMany(targetEntity="Category", mappedBy="parent")
     */
    private $children;

    /**
     * Many Categories have One Category.
     * @ManyToOne(targetEntity="Category", inversedBy="children")
     * @JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /**
     * @var string
     *
     * @ORM\Column(name="catName", type="string", length=255, unique=true)
     */
    private $catName;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\Article", inversedBy="categories")
     */
    private $article;

    public function __construct() {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
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
}
