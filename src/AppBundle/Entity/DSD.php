<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DSD
 *
 * @ORM\Table(name="d_s_d")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DSDRepository")
 */
class DSD
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="manufacturer", type="string", length=255)
     */
    private $manufacturer;

    /**
     * @var int
     *
     * @ORM\Column(name="item_sds", type="integer")
     */
    private $itemSds;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return DSD
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set manufacturer
     *
     * @param string $manufacturer
     *
     * @return DSD
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set itemSds
     *
     * @param integer $itemSds
     *
     * @return DSD
     */
    public function setItemSds($itemSds)
    {
        $this->itemSds = $itemSds;

        return $this;
    }

    /**
     * Get itemSds
     *
     * @return int
     */
    public function getItemSds()
    {
        return $this->itemSds;
    }
}

