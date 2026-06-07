<?php
require_once __DIR__ . '/../database_connection.php';

class BagRepository
{
    private $collection;

    public function __construct()
    {
        $this->collection = get_con_var()->bag;
    }

    public function findByUsername($username)
    {
        return $this->collection->findOne(['username' => $username]);
    }

    public function insert($username, $value, $jour)
    {
        $this->collection->insertOne([
            'username' => $username,
            'value' => (float)$value,
            'jour' => $jour
        ]);
    }

    public function upsert($username, $value, $jour)
    {
        $this->collection->updateOne(
            ['username' => $username],
            ['$set' => ['value' => (float)$value, 'jour' => $jour]]
        );
    }

    public function getMaxValue($username)
    {
        $cursor = $this->collection->aggregate([
            ['$match' => ['username' => $username]],
            ['$group' => ['_id' => null, 'maxx' => ['$max' => '$value']]]
        ]);
        foreach ($cursor as $doc) {
            return $doc['maxx'];
        }
        return 0;
    }

    public function getAll($username)
    {
        return $this->collection->find(['username' => $username]);
    }
}
