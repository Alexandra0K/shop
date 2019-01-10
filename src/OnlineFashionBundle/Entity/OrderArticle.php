<?php

namespace OnlineFashionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Expose;

/**
 * OrderArticle
 *
 * @ORM\Table(name="orderArticles")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\OrderArticleRepository")
 */
class OrderArticle
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
     * @ORM\Column(name="article_id", type="integer")
     * @Expose()
     */
    private $articleId;

    /**
     * @var Article
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\Article", inversedBy="orderArticles")
     * @ORM\JoinColumn(name="article_id", referencedColumnName="id")
     * @Expose()
     *
     */
    private $article;

//    /**
//     * @var Orderr
//     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\Orderr", inversedBy="orderArticles")
//     * @ORM\JoinColumn(name="orderr_id", referencedColumnName="id")
//     * @Expose()
//     *
//     */
//    private $orderr;
//    /**
//     * @var int
//     * @ORM\Column(name="orderr_id", type="integer")
//     * @Expose()
//     */
//    private $orderrId;

    /**
     * @var int
     * @ORM\Column(name="author_id", type="integer")
     * @Expose()
     */
    private $authorId;
    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="OnlineFashionBundle\Entity\User", inversedBy="orderArticles")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     * @Expose()
     *
     */
    private $author;

    /**
     * @var int
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;


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
     * Set amount.
     *
     * @param int $amount
     *
     * @return OrderArticle
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount.
     *
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set price.
     *
     * @param string $price
     *
     * @return OrderArticle
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getArticleId()
    {
        return $this->articleId;
    }

    /**
     * @param int $articleId
     * @return OrderArticle
     */
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
        return $this;
    }

//    /**
//     * @return int
//     */
//    public function getOrderrId()
//    {
//        return $this->orderrId;
//    }
//
//    /**
//     * @param int $orderrId
//     * @return OrderArticle
//     */
//    public function setOrderrId($orderrId=null)
//    {
//        $this->orderrId = $orderrId;
//        return $this;
//    }


    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     * @return OrderArticle
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
        return $this;
    }


    /**
     * @param User $author
     * @return OrderArticle
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
     * @param Article $article
     * @return OrderArticle
     */
    public function setArticle(Article $article = null)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

//
//    /**
//     * @param Orderr $orderr
//     * @return OrderArticle
//     */
//    public function setOrderr(Orderr $orderr=null)
//    {
//        $this->orderr = $orderr;
//        return $this;
//    }
//
//    /**
//     * @return Orderr
//     */
//    public function getOrderr()
//    {
//        return $this->orderr;
//    }
}
