<?php
require_once __DIR__ . '/../database_connection.php';

class BudgetRepository
{
    private $collection;

    public function __construct()
    {
        $this->collection = get_con_var()->budgets;
    }

    public function getLatest($username)
    {
        return $this->collection->findOne(
            ['username' => $username],
            ['sort' => ['_id' => -1]]
        );
    }

    public function getByFields($username, $salaire, $reste, $epargne)
    {
        return $this->collection->findOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne
        ]);
    }

    public function getSecondLast($username)
    {
        return $this->collection->findOne(
            ['username' => $username],
            ['sort' => ['_id' => -1], 'skip' => 1]
        );
    }

    public function insert($username, $salaire, $reste, $epargne)
    {
        $result = $this->collection->insertOne([
            'username' => $username,
            'salaire' => (float)$salaire,
            'rest_du_cheque_final' => (float)$reste,
            'epargne' => (float)$epargne,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);
        return $result;
    }
}
