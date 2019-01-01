<?php

namespace OnlineFashionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryParent
 *
 * @ORM\Table(name="categoryParents")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\CategoryParentRepository")
 */
class CategoryParent
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", unique=true)
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\Category", mappedBy="parentCats")
     * @ORM\Id
     *
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="parentCatName", type="string", length=255, unique=true)
     */
    private $parentCatName;

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
     * Set parentCatName.
     *
     * @param string $parentCatName
     *
     * @return CategoryParent
     */
    public function setParentCatName($parentCatName)
    {
        $this->parentCatName = $parentCatName;

        return $this;
    }

    /**
     * Get parentCatName.
     *
     * @return string
     */
    public function getParentCatName()
    {
        return $this->parentCatName;
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
