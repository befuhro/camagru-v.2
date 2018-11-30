<?php

class Database
{
    protected $_connection;

    public function __construct()
    {
        $this->_dataBase = new PDO('mysql:host=mysql:3306;dbname=camagru;charset=utf8',
            'root', 'rootpass',
            array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    }

    public function handleObject($query, $dataQuery)
    {
        $request = $this->_dataBase->prepare($query);
        $request->execute($dataQuery);
        $request->closeCursor();
    }

    public function getData($query, $dataQuery)
    {
        $request = $this->_dataBase->prepare($query);
        $request->execute($dataQuery);
        $data = $request->fetch();
        $request->closeCursor();
        return ($data);
    }


    public function getManyData($query, $dataQuery)
    {
        $array = [];
        $request = $this->_dataBase->prepare($query);
        $request->execute($dataQuery);
        while ($data = $request->fetch()) {
            array_push($array, $data);
        }
        $request->closeCursor();
        return ($array);
    }
}

abstract class Model
{
    protected $_dataBase;

    public function __construct(Database $db)
    {
        $this->_dataBase = $db;
    }
}