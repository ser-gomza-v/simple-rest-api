<?php


namespace SimpleRest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="goods")
 * @ORM\Entity(repositoryClass="SimpleRest\Repository\GoodsRepository")
 */
class Goods
{
    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    private $price;

    /**
     * @ORM\ManyToMany(targetEntity="Orders", mappedBy="goods")
     */
    private $orders;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $name
     * @return Goods
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $price
     * @return Goods
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function addOrder(Orders $orders)
    {
        if ($this->orders->contains($orders)) {
            return;
        }

        $this->orders->add($orders);
        $orders->addGoods($this);
    }

    public function removeOrder(Orders $orders)
    {
        if (!$this->orders->contains($orders)) {
            return;
        }

        $this->orders->remove($orders);
        $orders->removeGoods($this);
    }

}