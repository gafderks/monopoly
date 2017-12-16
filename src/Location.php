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
     * @Column(type="string")
     */
    private $lat;
    
    /**
     * @var double
     * @Column(type="string")
     */
    private $lon;
    
    public function getId() {
        return $this->id;
    }
    
    public function getOwnerships() {
        return $this->ownerships;
    }
    
    public function getName() {
        return utf8_encode($this->name);
    }
    
    public function getImage() {
        return utf8_encode($this->image);
    }
    
    public function getColor() {
        return utf8_encode($this->color);
    }
    
    public function getText() {
        return utf8_encode($this->text);
    }
    
    public function getLat() {
        return utf8_encode($this->lat);
    }
    
    public function getLon() {
        return utf8_encode($this->lon);
    }
    
    public function getPrice() {
        return (double) $this->price;
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
            "name" => $this->getName(),
            "image" => $this->getImage(),
            "color" => $this->getColor(),
            "text" => $this->getText(),
            "price" => (double) $this->price,
            "rent" => (double) $this->rent,
            "location" => [
                "lat" => (double) $this->getLat(),
                "lon" => (double) $this->getLon()
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
