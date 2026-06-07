<?php
require_once __DIR__ . '/../database_connection.php';

class UserRepository
{
    private $collection;

    public function __construct()
    {
        $this->collection = get_con_var()->users;
    }

    public function findByUsername($username)
    {
        return $this->collection->findOne(['_id' => $username]);
    }

    public function insert($username, $first_name, $last_name, $age, $passwrd, $date_payment)
    {
        $this->collection->insertOne([
            '_id' => $username,
            'passwrd' => password_hash($passwrd, PASSWORD_DEFAULT),
            'first_name' => $first_name,
            'last_name' => $last_name,
            'age' => (int)$age,
            'date_payment' => $date_payment
        ]);
    }

    public function update($username, $first_name, $last_name, $age, $date_payment)
    {
        $this->collection->updateOne(
            ['_id' => $username],
            ['$set' => [
                'first_name' => $first_name,
                'last_name' => $last_name,
                'age' => (int)$age,
                'date_payment' => $date_payment
            ]]
        );
    }

    public function getAll()
    {
        return $this->collection->find();
    }

    public function getFullName($username)
    {
        $user = $this->findByUsername($username);
        if ($user) {
            return $user['first_name'] . ' ' . $user['last_name'];
        }
        return '';
    }

    public function getDatePayment($username)
    {
        $user = $this->findByUsername($username);
        return $user ? $user['date_payment'] : null;
    }
}
