<?php
require_once __DIR__ . '/BaseRepository.php';

class BudgetRepository extends BaseRepository
{
    protected function collectionName(): string
    {
        return 'budgets';
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
            ['sort' => ['_id' => 1]]
        );
    }

    public function getAllDescending($username)
    {
        return $this->collection->find(
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
