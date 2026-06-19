<?php
require_once __DIR__ . '/BaseRepository.php';

class DepenseRepository extends BaseRepository
{
    protected function collectionName(): string
    {
        return 'depenses';
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
                '_id' => '$nom',
                'occurrences' => ['$sum' => 1],
                'prix' => ['$first' => '$prix']
            ]],
            ['$sort' => ['occurrences' => -1]],
            ['$project' => [
                'nom' => '$_id',
                'occurrences' => 1,
                '_id' => 0
            ]]
        ]);
    }

    public function getMonthlyTotals($username)
    {
        return $this->collection->aggregate([
            ['$match' => ['username' => $username]],
            ['$addFields' => [
                'parsedDate' => ['$dateFromString' => ['dateString' => '$ddate']]
            ]],
            ['$group' => [
                '_id' => ['$dateToString' => ['format' => '%Y-%m', 'date' => '$parsedDate']],
                'total' => ['$sum' => ['$multiply' => ['$prix', '$quantite']]]
            ]],
            ['$sort' => ['_id' => 1]]
        ]);
    }

    public function getTopByTotalCost($username, $limit = 10)
    {
        return $this->collection->aggregate([
            ['$match' => ['username' => $username, 'nom' => ['$ne' => 'begin']]],
            ['$group' => [
                '_id' => '$nom',
                'total' => ['$sum' => ['$multiply' => ['$prix', '$quantite']]]
            ]],
            ['$sort' => ['total' => -1]],
            ['$limit' => $limit],
            ['$project' => ['nom' => '$_id', 'total' => 1, '_id' => 0]]
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
