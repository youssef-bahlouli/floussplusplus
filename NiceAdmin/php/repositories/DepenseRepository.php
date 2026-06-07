<?php
require_once __DIR__ . '/../database_connection.php';

class DepenseRepository
{
    private $collection;

    public function __construct()
    {
        $this->collection = get_con_var()->depenses;
    }

    public function getLatest($username)
    {
        return $this->collection->findOne(
            ['username' => $username],
            ['sort' => ['_id' => -1]]
        );
    }

    public function getAll($username)
    {
        return $this->collection->find(
            ['username' => $username],
            ['sort' => ['_id' => -1]]
        );
    }

    public function getAllOrderedByOccurrence($username)
    {
        return $this->collection->aggregate([
            ['$match' => ['username' => $username]],
            ['$group' => [
                '_id' => '$type',
                'total' => ['$sum' => 1],
                'prix' => ['$first' => '$prix']
            ]],
            ['$sort' => ['total' => -1]]
        ]);
    }

    public function insert($username, $nom, $description, $type, $prix, $q, $budgetId, $ddate)
    {
        $this->collection->insertOne([
            'username' => $username,
            'nom' => $nom,
            'description' => $description,
            'type' => $type,
            'prix' => (float)$prix,
            'quantite' => (int)$q,
            'ddate' => $ddate,
            'budget_id' => $budgetId
        ]);
    }
}
