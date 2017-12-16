<?php
$config = include('config.php');
require_once('bootstrap.php');

function createTeam($name) {
    global $entityManager;
    global $config;
    if (is_null(getTeamByName($name))) {
        try {
            
            $team = new \Team($name);
            $transaction = new \MyTransaction($config['startBudget'], new
            \DateTime("now"),
                $team);
            $team->addTransaction($transaction);
            $entityManager->persist($team);
            $entityManager->persist($transaction);
            $entityManager->flush();
        } catch (Exception $e) {
   var_dump($e->getTrace());}

    
    }
}

function buyProperty($name, $locationId) {
    global $entityManager;
    global $config;
    $team = getTeamByName($name);
    $location = getLocation($locationId);
    $transaction = new \MyTransaction(-1 * $location->getPrice(), new
    \DateTime('now'), $team);
    $team->addTransaction($transaction);
    $ownership = new \Ownership(new \DateTime("now"), $team, $location);
    $team->addOwnership($ownership);
    $entityManager->persist($team);
    $entityManager->persist($transaction);
    $entityManager->persist($ownership);
    $entityManager->flush();
}

function awardBonus($name) {
    global $entityManager;
    global $config;
    $team = getTeamByName($name);
    $transaction = new \MyTransaction($config['bonusAmount'], new
    \DateTime('now'), $team);
    $team->addTransaction($transaction);
    $entityManager->persist($team);
    $entityManager->persist($transaction);
    $entityManager->flush();
}

function payRent($from, $to, $amount) {
    global $entityManager;
    $from = getTeamByName($from);
    $to = getTeamByName($to);
    $transactionFrom = new \MyTransaction(-1 * $amount, new
    \DateTime('now'), $from);
    $transactionTo = new \MyTransaction($amount, new
    \DateTime('now'), $to);
    $from->addTransaction($transactionFrom);
    $to->addTransaction($transactionTo);
    $entityManager->persist($from);
    $entityManager->persist($to);
    $entityManager->persist($transactionFrom);
    $entityManager->persist($transactionTo);
    $entityManager->flush();
}

/**
 * @return \Team[]
 */
function getTeams() {
    global $entityManager;
    return $entityManager->getRepository('Team')->findAll();
}

/**
 * @return \Team[]
 */
function getLocations() {
    global $entityManager;
    return $entityManager->getRepository('Location')->findAll();
}

/**
 * @param $id
 *
 * @return \Location
 */
function getLocation($id) {
    global $entityManager;
    return $entityManager->getRepository('Location')->find($id);
}

/**
 * @param Team $team
 *
 * @return \MyTransaction[]
 */
function getTransactionsForTeam(\Team $team) {
    global $entityManager;
    return $entityManager->getRepository('MyTransaction')->findBy(['team' =>
                                                                     $team]);
}

/**
 * @param $id
 * @return \Team
 */
function getTeamByName($name) {
    global $entityManager;
    return $entityManager->getRepository('Team')->findOneBy(['teamName' =>
                                                                 $name]);
}