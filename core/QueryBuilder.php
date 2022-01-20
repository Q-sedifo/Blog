<?php

namespace core;

use core\Db;
use PDO;

class QueryBuilder extends Db
{ 

    private function query($sql, $params = [])
    {
        $stmt = $this->db->prepare($sql);
        
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue(':' . $key, $value);
            }
        }

        $stmt->execute();
        return $stmt;
    }

    public function row($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function column($sql, $params = [])
    {
        return $this->query($sql, $params)->fetchColumn();
    }

}