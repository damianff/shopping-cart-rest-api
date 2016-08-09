<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMSSerializer;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\ItemRepository")
 * @ORM\Table(name="item")
 * @JMSSerializer\ExclusionPolicy("all")
 */
class Item implements \JsonSerializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMSSerializer\Expose
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="name", nullable=false)
     * @JMSSerializer\Expose
     */
    private $name;

    /**
     * @ORM\Column(type="string", name="description", nullable=false)
     * @JMSSerializer\Expose
     */
    private $description;

    /**
     * @ORM\Column(type="decimal",  precision=8, scale=2, name="price", nullable=false)
     * @JMSSerializer\Expose
     */
    private $price;     


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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;

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
     * @return Item
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }    

    /**
     * @return mixed
     */
    function jsonSerialize()
    {
        return [
            'id'    => $this->id,
            'name' => $this->name,
            'description'  => $this->description,
            'price'  => $this->price,
        ];
    }

}