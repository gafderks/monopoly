<?php

include_once "controller.php";
global $entityManager;

header('Content-Type: application/json');

switch ($_GET['action']) {
    case "create":
        switch ($_GET['resource']) {
            case "team":
                createTeam($_POST['name']);
                break;
            case "ownership":
                buyProperty($_POST['name'], $_POST['location']);
                break;
            case "transaction":
                switch ($_POST['type']) {
                    case "bonus":
                        awardBonus($_POST['name']);
                        break;
                    case "rent":
                        payRent($_POST['from'], $_POST['to'], $_POST['amount']);
                        break;
                }
                break;
            default:
                print "Unsupported resource";
        }
        break;
    case "list":
        switch ($_GET['resource']) {
            case "transactions":
                $transactions = getTransactionsForTeam(getTeamByName($_GET['name']));
                $result = [];
                foreach ($transactions as $transaction) {
                    array_push($result, $transaction->toJSON());
                }
                print json_encode($result);
                break;
            case "locations":
                $locations = getLocations();
                $result = [];
                foreach ($locations as $location) {
                    array_push($result, $location->toJSON());
                }
                print json_encode($result);
                break;
            case "scores":
                $teams = getTeams();
                $result = [];
                foreach ($teams as $team) {
                    array_push($result, $team->getScore());
                }
                print json_encode($result);
                break;
            default:
                print "Unsupported resource";
        }
        break;
    default:
        print "Unsupported action";
}