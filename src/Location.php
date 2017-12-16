<?php
// src/Location.php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Location
 *
 * @Entity
 */
class Location
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var string
     * @Column(type="string")
     */
    protected $name;
    
    /**
     * @OneToMany(targetEntity="Ownership", mappedBy="location")
     * @var \Ownership[]
     */
    private $ownerships;
    
    /**
     * @var string
     * @Column(type="string")
     */
    private $color;
    
    /**
     * @var string
     * @Column(type="string")
     */
    private $text;
    
    /**
     * @var string
     * @Column(type="string")
     */
    private $image;
    
    /**
     * @var double
     * @Column(type="decimal")
     */
    private $price;
    
    /**
     * @var double
     * @Column(type="decimal")
     */
    private $rent;
    
    /**
     * @var double
     * @Column(type="decimal")
     */
    private $lat;
    
    /**
     * @var double
     * @Column(type="decimal")
     */
    private $lon;
    
    public function getId() {
        return $this->id;
    }
    
    public function getOwnerships() {
        return $this->ownerships;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function getImage() {
        return $this->image;
    }
    
    public function getColor() {
        return $this->color;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function getLat() {
        return $this->lat;
    }
    
    public function getLon() {
        return $this->lon;
    }
    
    public function getPrice() {
        return $this->price;
    }
    
    public function getRent() {
        return $this->rent;
    }
    
    public function getActiveOwnershipTeamName() {
        foreach ($this->ownerships as $ownership) {
            if ($ownership->isActive()) {
                return $ownership->getTeam()->getTeamName();
            }
        }
        return null;
    }
    
    public function toJSON() {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "color" => $this->color,
            "text" => $this->text,
            "price" => (double) $this->price,
            "rent" => (double) $this->rent,
            "location" => [
                "lat" => (double) $this->lat,
                "lon" => (double) $this->lon
            ],
            "owner" => $this->getActiveOwnershipTeamName()
        ];
    }
    
    public function __construct() {
        $this->ownerships = new ArrayCollection();
    }
    
    public function addOwnership(\Ownership $ownership) {
        $this->ownerships->add($ownership);
    }
    
}