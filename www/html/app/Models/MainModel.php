<?php
namespace App\Models;

use PDO;
use Exception;

class MainModel
{
  public function __construct($options)
  {
    if ($options['env'] == 'test') {
      $this->db_name = 'test_database';
    } else {
      $this->db_name = 'customer_database';
    }
    $this->table = $options['table'];
  }

  const HOST='db';
  const UTF='utf8';
  const USER='root';
  const PASS='secret';

  protected function select()
  {
    $pdo = $this->pdo();
    $sql = "Select * from " . $this->table;
    $stmt = $pdo->query($sql);
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $items;
  }

  protected function selectWhere($where = [], $not_where = [])
  {
    $values = [];
    $pdo = $this->pdo();
    $sql = "Select * from " . $this->table . " Where ";
    $sql .= !empty($where) ? $this->getWhere($where) : "";
    $sql .= !empty($where) && !empty($not_where) ? " and " : "";
    $sql .= !empty($not_where) ? $this->getWhere($not_where, true) : "";
    $stmt = $pdo->prepare($sql);
    if (!empty($where)) {
      $values = array_values($where);
    }
    if (!empty($not_where)) {
      $values = array_merge($values, array_values($not_where));
    }
    $stmt->execute($values);
    return $stmt->fetchColumn();
  }

  protected function create($items)
  {
    $pdo = $this->pdo();
    $columns = $this->getColumns($items);
    $params = $this->getParams($items);
    $stmt = $pdo->prepare(
      "Insert Into " . $this->table . " (" . $columns .") Values (" . $params . ")"
    );
    return $stmt->execute(
      array_values($items)
    );
  }

  protected function update($items, $id)
  {
    $pdo = $this->pdo();
    $columns = $this->getColumnsAndParams($items);
    $stmt = $pdo->prepare(
      "Update " . $this->table . " Set " . $columns . " Where id = ?"
    );
    return $stmt->execute(
      array_merge(array_values($items), [$id])
    );
  }

  protected function delete($id)
  {
    $pdo = $this->pdo();
    $stmt = $pdo->prepare(
      "Delete from " . $this->table . " Where id = ?"
    );
    return $stmt->execute(
      [$id]
    );
  }

  protected function deleteAll(){
    $pdo = $this->pdo();
    $stmt = $pdo->prepare(
      "Delete from " . $this->table
    );
    return $stmt->execute();
  }

  protected function isEmail($param)
  {
    $error = '';
    if (!filter_var($param, FILTER_VALIDATE_EMAIL))
    {
      $error = 'Input correctly email';
    }
    return $error;
  }

  protected function hasEmail($email, $id)
  {
    $error = "";
    $list = $this->selectWhere($email, $id);
    if (!empty($list))
    {
      $error = 'This email already registered';
    }
    return $error;
  }

  protected function isEmpty($param)
  {
    $error = '';
    $key = key($param);
    $value = $param[$key];

    if (empty($value)) {
      $error = "Input " . $key;
    }
    return $error;
  }

  private function pdo()
  {
    $dsn = "mysql:dbname=".$this->db_name.";host=".self::HOST.";charset=".self::UTF;
    $user = self::USER;
    $pass = self::PASS;
    try
    {
      $pdo = new PDO( $dsn, $user, $pass, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES ".SELF::UTF]);
    }
    catch(Exception $e)
    {
      echo "error".$e->getMesseage;
      die();
    }
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    return $pdo;
  }

  private function getColumns($items)
  {
    $sql = '';
    $c = 1;
    $length = count($items);

    foreach($items as $key => $value)
    {
      if ($length === $c) {
        $sql .= $key;
      } else {
        $sql .= $key . ', ';
      }
      $c++;
    }
    return $sql;
  }

  private function getParams($items)
  {
    $sql = '';
    $c = 1;
    $length = count($items);

    foreach($items as $key => $value)
    {
      if ($length === $c) {
        $sql .= '?';
      } else {
        $sql .= '?, ';
      }
      $c++;
    }
    return $sql;
  }

  private function getColumnsAndParams($items) {
    $sql = '';
    $c = 1;
    $length = count($items);

    foreach($items as $key => $value)
    {
      if ($length === $c)
      {
        $sql .= $key . " = ?";
      }
      else
      {
        $sql .= $key . ' = ?, ';
      }
      $c++;
    }
    return $sql;
  }

  private function getWhere($items, $is_not = false) {
    $sql = '';
    $c = 1;
    $length = count($items);

    foreach($items as $key => $value)
    {
      if ($is_not)
      {
        if ($length === $c)
        {
          $sql .= $key . " != ?";
        }
        else
        {
          $sql .= $key . ' != ? and ';
        }
      }
      else
      {
        if ($length === $c)
        {
          $sql .= $key . " = ?";
        }
        else
        {
          $sql .= $key . ' = ? and ';
        }
      }
      $c++;
    }
    return $sql;
  }

}