<?php
// src/Team.php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Team
 *
 * @Entity
 */
class Team
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
    protected $teamName;
    
    /**
     * One Product has Many Features.
     * @OneToMany(targetEntity="Ownership", mappedBy="team")
     * @var \Ownership
     */
    protected $ownerships;
    
    /**
     * One Product has Many Features.
     * @OneToMany(targetEntity="MyTransaction", mappedBy="team")
     * @var \MyTransaction
     */
    private $transactions;
    
    public function getId() {
        return $this->id;
    }
    
    public function getTransactions() {
        return $this->transactions;
    }
    
    public function getTeamName() {
        return $this->teamName;
    }
    
    public function __construct($teamName) {
        $this->teamName = $teamName;
        $this->transactions = new ArrayCollection();
        $this->ownerships = new ArrayCollection();
    }
    
    public function addTransaction(\MyTransaction $transaction) {
        $this->transactions->add($transaction);
    }
    
    public function addOwnership(\Ownership $ownership) {
        $this->ownerships->add($ownership);
    }
    
    public function getScore() {
        $numOwnerships = 0;
        $estate = 0;
        foreach($this->ownerships as $ownership) {
            if ($ownership->isActive()) {
                $numOwnerships++;
                $estate += $ownership->getLocation()->getPrice();
            }
        }
        
        $balance = 0;
        foreach ($this->transactions as $transaction) {
            $balance += $transaction->getAmount();
        }
        
        return [
            "name" => $this->getTeamName(),
            "ownerships" => $numOwnerships,
            "balance" => $balance,
            "estate" => $estate,
        ];
    }
    
}