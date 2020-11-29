<?php


class DB
{
    private $db_host = '';
    private $db_name = '';
    private $db_user = '';
    private $db_pass = '';

    private $mysqli = '';


    public function __construct()
    {

        $this->db_host = getenv('DB_HOST');
        $this->db_name = getenv('DB_NAME');
        $this->db_user = getenv('DB_USER');
        $this->db_pass = getenv('DB_PASSWORD');

        $this->mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);

        // Check connection
        if ($this->mysqli->connect_error) {
            die("Connection failed: " . $this->mysqli->connect_error);
        }

        $this->create_table('users');
    }

    public function create_table($table_name)
    {
        $sql = 'CREATE TABLE IF NOT EXISTS ' . $table_name . ' (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        password VARCHAR(30) NOT NULL,
        email VARCHAR(50),
        reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )';

        $rez = $this->make_query($sql);

        if ($rez !== true) {
            echo $rez;
        }
    }

    public function select($table_name, $args)
    {

        $where = '';
        foreach ($args as $key => $value) {
            if ($where) {
                $where .= ' AND ';
            }

            $where .= $key . '=';
            $where .= '\'' . $value . '\'';
        }

        $sql = "SELECT * FROM `$table_name` WHERE $where";

        $rez = $this->make_query($sql);

        if ($rez !== true) {
            return $rez;
        }
    }

    public function write($table_name, $args)
    {

        $columns = '`id`';
        $values = 'NULL';

        foreach ($args as $key => $value) {

            $columns .= ', `' . $key . '`';
            $values .= ', \'' . $value . '\'';
        }

        $sql = "INSERT INTO `$table_name` ($columns) VALUES ($values)";

        $rez = $this->make_query($sql);

        if ($rez !== true) {
            return $rez;
        }

        return true;

    }

    private function make_query($sql)
    {
        $res = $this->mysqli->query($sql);

        if ($res === true) {
            return true;
        } elseif ($res->num_rows) {
            $rows = array();

            for ($row_no = $res->num_rows - 1; $row_no >= 0; $row_no--) {
                $res->data_seek($row_no);
                $row = $res->fetch_assoc();
                array_push($rows, $row);
            }

            return $rows;
        } else {
            return $this->mysqli->error;
        }
    }

    public function __destruct()
    {
        $this->mysqli->close();
    }
}