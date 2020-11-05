<?php


namespace SimpleRest\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="SimpleRest\Repository\OrdersRepository")
 */
class Orders
{
    const ORDER_NEW = 0;
    const ORDER_PAID = 1;

    /**
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="Goods", inversedBy="orders")
     * @ORM\JoinTable(
     *     name="orders_goods",
     *     joinColumns={
     *          @ORM\JoinColumn(name="order_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="good_id", referencedColumnName="id")
     *     }
     * )
     */
    private $goods;

    public function __construct()
    {
        $this->goods = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $status
     * @return Orders
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function addGoods(Goods $goods)
    {
        if ($this->goods->contains($goods)) {
            return;
        }

        $this->goods->add($goods);
        $goods->addOrder($this);
    }

    public function removeGoods(Goods $goods)
    {
        if (!$this->goods->contains($goods)) {
            return;
        }

        $this->goods->remove($goods);
        $goods->removeOrder($this);
    }
}