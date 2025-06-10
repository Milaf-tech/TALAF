<?php
class Connection extends SQLite3 {
    function __construct() {
        $this->open('Talaf.db');
    }

    function command($cmd, $params = []) {
        $stmt = $this->prepare($cmd);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, SQLITE3_TEXT);
        }
        return $stmt->execute();
    }

    function myData($query, $params = []) {
        $stmt = $this->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, SQLITE3_TEXT);
        }
        $result = $stmt->execute();
        $array = [];
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $array[] = $row;
        }
        return $array;
    }
}
?>
