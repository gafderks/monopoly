<?php
// src/Ownership.php

/**
 * Class Ownership
 *
 * @Entity
 */
class Ownership
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ManyToOne(targetEntity="Team", inversedBy="ownerships",
     *     cascade={"persist"})
     * @JoinColumn(name="team_id", referencedColumnName="id")
     * @var \Team
     */
    private $team;
    
    /**
     * @ManyToOne(targetEntity="Location", inversedBy="ownerships",
     *     cascade={"persist"})
     * @JoinColumn(name="ownership_id", referencedColumnName="id")
     * @var \Team
     */
    private $location;
    
    /**
     * @Column(type="datetime")
     */
    protected $timestamp;
    
    public function getId() {
        return $this->id;
    }
    
    public function getLocation() {
        return $this->location;
    }
    
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    public function getTeam() {
        return $this->team;
    }
    
    public function __construct(\DateTime $time, \Team $team,
        \Location $location) {
        $this->timestamp = $time;
        $this->team = $team;
        $this->location = $location;
    }
    
    public function isActive() {
        $now = new \DateTime("now");
        $price = $this->location->getPrice();
        $interval = new \DateInterval("PT{$price}M");
        $interval->invert = 1;
        $earliest = $now->add($interval);
        return $this->timestamp >= $earliest;
    }
}