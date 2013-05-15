<?php
class Db
{

    private $host   = 'localhost';
    private $dbUser = 'nfa021';
    private $dbPwd  = 'nfa021';
    private $dbName = 'nfa021';
    private $link;

    public function __construct()
    {

        $this->link = mysqli_connect($this->host, $this->dbUser, $this->dbPwd, $this->dbName);
        mysqli_set_charset($this->link, "utf8");

    }

    public function getRow($sql)
    {
        
        $rs = mysqli_query($this->link, $sql);

        if ($rs === false)
            return null;

        return mysqli_fetch_assoc($rs);

    }

    public function getRowset($sql)
    {

        $rs = mysqli_query($this->link, $sql);

        if ($rs === false)
            return array();

        $result = array();
        while ($row = mysqli_fetch_assoc($rs)) {
            $result[] = $row;
        }

        return $result;

    }

}