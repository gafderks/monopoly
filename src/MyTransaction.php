<?php
// src/Transaction.php

/**
 * Class MyTransaction
 *
 * @Entity
 */
class MyTransaction
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * Many Transactions have One Team.
     * @ManyToOne(targetEntity="Team", inversedBy="transactions")
     */
    protected $team;
    
    /**
     * @Column(type="datetime")
     */
    protected $timestamp;
    
    /**
     * @var double
     * @Column(type="decimal")
     */
    protected $amount;
    
    public function getId() {
        return $this->id;
    }
    
    public function getAmount() {
        return (double) $this->amount;
    }
    
    public function getTimestamp() {
        return $this->timestamp;
    }
    
    public function getTeam() {
        return $this->team;
    }
    
    public function toJSON() {
        return [
            "timestamp" => $this->getTimestamp()->getTimestamp(),
            "amount" => (double) $this->getAmount(),
        ];
    }
    
    public function __construct($amount, \DateTime $time, \Team $team) {
        $this->amount = $amount;
        $this->timestamp = $time;
        $this->team = $team;
    }
}