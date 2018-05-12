<?php
// src/Notification.php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Notification
 *
 * @Entity
 */
class Notification
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
    protected $text;
    
    /**
     * @var string
     * @Column(type="string")
     */
    protected $type;
    
    public function getId() {
        return $this->id;
    }
    
    public function getText() {
        return $this->text;
    }
    
    public function getType() {
        return $this->type;
    }
    
    public function __construct($text, $type) {
        $this->text = $text;
        $this->type = $type;
    }
    
    public function toJSON() {
        return [
            "id" => $this->id,
            "text" => $this->getText(),
            "type" => $this->getType()
        ];
    }
    
}