<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OrderRepository")
 * @ORM\Table(name="shopping_order")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Order implements \JsonSerializable
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="date", name="date", nullable=false)
     * @JMSSerializer\Expose
     */
    private $date;    

    /**
     * @ORM\Column(type="decimal",  precision=8, scale=2, name="total", nullable=false)
     * @JMSSerializer\Expose
     */
    private $total;      

    /**
     * @ORM\Column(type="date", name="last_update")
     * @JMSSerializer\Expose
     */
    private $lastUpdate; 

    /**
     * @ORM\OneToMany(targetEntity="LineItem", mappedBy="order", cascade={"persist", "remove"})
     * @JMSSerializer\Expose     
    */  
    private $items;  


    public function __construct(){
        $this->items = new ArrayCollection();
        $this->date = new \DateTime();
        $this->lastUpdate = new \DateTime();
        $this->total = 0;
    }    

    /**
     * @return \Doctrine\Common\Collections\Collectio
     */
    public function getItems(){
        return $this->items;
    }    
 
    /**
     * Add item
     *
     * @param AppBundle\Entity\Item $item
     * @return Organisation
     */
    public function addItem(\AppBundle\Entity\Item $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param AppBundle\Entity\Item $item
     */
    public function removeItem(\AppBundle\Entity\Item $item)
    {
        $this->items->removeElement($item);
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     * @return Order
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     * @return Order
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }      

    /**
     * @return mixed
     */
    public function getLastUpdate()
    {
        return $this->lastUpdate;
    }

    /**
     * @param mixed $lastUpdate
     * @return Order
     */
    public function setLastUpdate($lastUpdate)
    {
        $this->lastUpdate = $lastUpdate;

        return $this;
    }    

    /**
     * @return mixed
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'date' => $this->date,
            'lastUpdate'  => $this->lastUpdate,
            'total' => $this->total,            
            'items' => $this->items
        ];
    }

}