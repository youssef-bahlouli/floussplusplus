<?php
require_once __DIR__ . '/../database_connection.php';

abstract class BaseRepository
{
    protected $collection;

    abstract protected function collectionName(): string;

    public function __construct()
    {
        $this->collection = get_con_var()->{$this->collectionName()};
    }
}
