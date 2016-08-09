<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\LineItemRepository")
 * @ORM\Table(name="line_item")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class LineItem implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="decimal", name="quantity", nullable=false)
     * @JMSSerializer\Expose
     */
    private $quantity;     


    /**
     * @ORM\Column(type="decimal",  precision=8, scale=2, name="price", nullable=false)
     * @JMSSerializer\Expose
     */
    private $price;     

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="item", referencedColumnName="id")
     * })    
     */
    private $item;

    /**
     * @var Order
     *
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="items")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="shopping_order", referencedColumnName="id")
     * })   
     */
    private $order;

    public function __construct(\AppBundle\Entity\Order $order)
    {
        $this->order = $order;        
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     * @return LineItem
     */
    public function setQuantity($quantity)
    {
        $this->name = $quantity;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }    

    /**
     * @param mixed $price
     * @return LineItem
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }  

    /**
     * Set item
     *
     * @param AppBundle\Entity\Item $item
     */
    public function setItem(\AppBundle\Entity\Item $item)
    {
        $this->item = $item;
    }

    /**
     * Get item
     *
     * @return AppBundle\Entity\Item 
     */
    public function getItem()
    {
        return $this->item;
    }        

    /**
     * Set order
     *
     * @param AppBundle\Entity\Order $order
     */
    public function setOrder(\AppBundle\Entity\Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get order
     *
     * @return AppBundle\Entity\Order 
     */
    public function getOrder()
    {
        return $this->order;
    }     

    /**
     * @return mixed
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'quantity' => $this->quantity,
            'price'  => $this->price,
            'item' => $this->item,
            'order' => $this->order,            
        ];
    }

}