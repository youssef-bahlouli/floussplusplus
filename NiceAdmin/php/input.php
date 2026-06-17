<?php
    require_once __DIR__ . '/repositories/BudgetRepository.php';
    require_once __DIR__ . '/repositories/DepenseRepository.php';
    require_once __DIR__ . '/repositories/UserRepository.php';
    require_once __DIR__ . '/services/LogService.php';
    function input_depenses($dbconn,$username,$nom,$description,$type,$prix,$q){
        $budgetRepo = new BudgetRepository();
        $l = $budgetRepo->getLatest($username);
        $reste = $l['rest_du_cheque_final'];
        $epargne = $l['epargne'];
        $salaire = $l['salaire'];
        $total = $q * $prix;
        if($reste <= $total){
            $total -= $reste;
            $reste = 0;
            $epargne -= $total;
        }else{
            $reste -= $total;
        }
        $budgetResult = $budgetRepo->insert($username, $salaire, $reste, $epargne);
        $ddate = (new DateTime())->format("Y-m-d H:i:s");
        (new DepenseRepository())->insert($username, $nom, $description, $type, $prix, $q, $budgetResult->getInsertedId(), $ddate);
        log_action($username, 'add_depense', "$nom - $total MAD ($type)");
    }
    function input_salaire($username,$salaire,$reste,$condition){
        $budgetRepo = new BudgetRepository();
        $budget = $budgetRepo->getLatest($username);
        $epargne = 0;
        if($budget) $epargne = $budget['epargne'];
        $budgetRepo->insert($username, $salaire, $reste, $epargne);
        log_action($username, 'add_salaire', "Salary: $salaire MAD, Balance: $reste MAD");
    }
    function input_epargne($username,$epargne,$reponse){
        $budgetRepo = new BudgetRepository();
        $latest = $budgetRepo->getLatest($username);
        $reste = $latest['rest_du_cheque_final'];
        $salaire = $latest['salaire'];
        if($reponse == "yes"){
            $epargne += $latest['epargne'];
        }
        $budgetRepo->insert($username, $salaire, $reste, $epargne);
        log_action($username, 'add_epargne', "Savings: $epargne MAD");
    }
    function input_receive_salary($username,$salaire){
        $budgetRepo = new BudgetRepository();
        $latest = $budgetRepo->getLatest($username);
        $oldEpargne = $latest ? (float)$latest['epargne'] : 0;
        $oldReste = $latest ? (float)$latest['rest_du_cheque_final'] : 0;
        $newEpargne = $oldEpargne + $oldReste;
        $budgetRepo->insert($username, (float)$salaire, (float)$salaire, $newEpargne);
        log_action($username, 'receive_salary', "Salary: $salaire MAD (previous rest $oldReste MAD moved to savings)");
    }
    function input_budget($connexion,$username,$salaire,$reste,$epargne){
        (new BudgetRepository())->insert($username, $salaire, $reste, $epargne);
    }
?>
