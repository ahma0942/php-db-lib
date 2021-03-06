<?php
namespace PHPDbLib\Database;

class TableActions {
    private $table;
    private $tables;
    private $connection;
    private $db;

    function __construct($table,$tables,$connection,$db)
    {
        $this->table=$table;
        $this->tables=$tables;
        $this->connection=$connection;
        $this->db=$db;
    }

    public function select($arr)
    {
        if (!empty($arr)) $this->tables[$this->table]->select($arr);
        return $this;
    }

    public function unselect($arr)
    {
        if (!empty($arr)) $this->tables[$this->table]->unselect($arr);
        return $this;
    }

    public function where($arr)
    {
        if (!empty($arr)) $this->tables[$this->table]->where($arr);
        return $this;
    }

    public function join($arr)
    {
        if (!empty($arr)) {
            $this->tables[$this->table]->addTables($this->tables);
            $this->tables[$this->table]->join($arr);
        }
        return $this;
    }

    public function _join($arr)
    {
        if (!empty($arr)) {
            $this->tables[$this->table]->addTables($this->tables);
            $this->tables[$this->table]->noCheckJoin($arr);
        }
        return $this;
    }

    public function read($perpage = null, $page = null)
    {
        return $this->tables[$this->table]->read($perpage, $page, $this->connection);
    }

    public function update($arr)
    {
        if (!empty($arr)) return $this->tables[$this->table]->update($arr, $this->connection);
    }

    public function delete($arr)
    {
        $this->tables[$this->table]->delete($arr, $this->connection);
    }

    public function insert($cols=[], $arr=[])
    {
        if (!empty($cols) && empty($arr) && is_array($cols[0]))
            return $this->tables[$this->table]->insert(array_shift($cols), $cols, $this->connection);
        return $this->tables[$this->table]->insert($cols, $arr, $this->connection);
    }

    public function checkInsert($cols, $arr, $cols2 = [], $arr2 = [])
    {
        if (empty($cols2) && empty($arr2)) {
            $cols2 = $cols;
            $arr2 = $arr;
        } elseif(empty($arr2)) {
            foreach($cols2 AS $c)
                $arr2[] = $arr[array_search($c, $cols)];
        }
        return $this->tables[$this->table]->checkInsert($cols, $arr, $cols2, $arr2, $this->connection);
    }

    public function exist($cols, $arr)
    {
        return $this->tables[$this->table]->exist($cols, $arr, $this->connection);
    }

    public function count($cols, $arr)
    {
        return $this->tables[$this->table]->count($cols, $arr, $this->connection);
    }

    public function orderby($order = null)
    {
        $this->tables[$this->table]->orderby($order);
        return $this;
    }

    public function readonly($set = true)
    {
        $this->tables[$this->table]->readonly($set);
        return $this;
    }
}
