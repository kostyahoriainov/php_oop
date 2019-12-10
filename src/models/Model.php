<?php


namespace models;

use \PDO;

abstract class Model
{
    protected static function fetchData(PDO $connection, string $sql, array $params = [], int $fetch_type = PDO::FETCH_ASSOC)
    {
        $query = $connection->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $param) {
                $query->bindValue($key, $param);
            }
        }
        $query->execute();

        $data = $query->fetchAll($fetch_type);

        return $data;
    }

    protected static function insertData(PDO $connection, string $sql, array $params = []): bool
    {
        $query = $connection->prepare($sql);

        if (!empty($params)) {
            foreach ($params as $key => $param) {
                $query->bindValue($key, $param);
            }
        }
        $result = $query->execute();

        return $result;
    }
}