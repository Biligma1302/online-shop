<?php

namespace Model;

use PDO;

abstract class Model
{
 protected PDO $pdo;

 public function __construct()  {
     $this->pdo = new PDO('pgsql:host=postgres_db; port=5432;dbname=dugarovadb', 'dugarova', 'Dugarova1302');
 }
 abstract protected function getTableName(): string;
}