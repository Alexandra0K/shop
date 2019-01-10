<?php

namespace OnlineFashionBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DateTime;
use JMS\Serializer\Annotation\Expose;

/**
 * Orderr
 *
 * @ORM\Table(name="orderrs")
 * @ORM\Entity(repositoryClass="OnlineFashionBundle\Repository\OrderrRepository")
 */
class Orderr
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id=null;


    /**
     * @var int
     * @ORM\Column(name="author_id", type="integer")
     * @Expose()
     */
    private $authorId;


    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createDate", type="datetime")
     */
    private $createDate;

    /**
     * @var string
     *
     * @ORM\Column(name="deliveryAddress", type="text")
     */
    private $deliveryAddress;
    /**
     * @var ArrayCollection| OrderArticle[]
     * @ORM\OneToMany(targetEntity="OnlineFashionBundle\Entity\OrderArticle", mappedBy="orderr")
     * @Expose()
     */
    private $orderArticles;

    public function __construct()
    {
        $this->createDate = new DateTime('now');

        $this->orderArticles = new ArrayCollection();
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
     * Set description.
     *
     * @param string $description
     *
     * @return Orderr
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createDate.
     *
     * @param \DateTime $createDate
     *
     * @return Orderr
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate.
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set deliveryAddress.
     *
     * @param string $deliveryAddress
     *
     * @return Orderr
     */
    public function setDeliveryAddress($deliveryAddress)
    {
        $this->deliveryAddress = $deliveryAddress;

        return $this;
    }

    /**
     * Get deliveryAddress.
     *
     * @return string
     */
    public function getDeliveryAddress()
    {
        return $this->deliveryAddress;
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
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }


    /**
     * @return ArrayCollection|OrderArticle[]
     */
    public function getOrderArticles()
    {
        return $this->orderArticles;
    }

    /**
     * @param OrderArticle $orderArticle
     * @return Orderr
     */
    public function addOA(OrderArticle $orderArticle)
    {
        $this->orderArticles[] = $orderArticle;
        return $this;
    }
}
