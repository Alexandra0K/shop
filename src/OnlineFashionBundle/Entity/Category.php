<?php

namespace OnlineFashionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var int
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\CategoryParent", inversedBy="id")
     *
     */
    private $parentCats;

    /**
     * @var string
     *
     * @ORM\Column(name="catName", type="string", length=255, unique=true)
     */
    private $catName;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\Article", inversedBy="comments")
     */
    private $article;

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
     * Set catName.
     *
     * @param string $catName
     *
     * @return Category
     */
    public function setCatName($catName)
    {
        $this->catName = $catName;

        return $this;
    }

    /**
     * Get catName.
     *
     * @return string
     */
    public function getCatName()
    {
        return $this->catName;
    }

    /**
     * @return int
     */
    public function getParentCats()
    {
        return $this->parentCats;
    }

    /**
     * @param int $parentCats
     */
    public function setParentCats($parentCats)
    {
        $this->parentCats = $parentCats;
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

}
