<?php
/**
 * @author Denis Fohl
 */
abstract class FormAbstract
{

    protected $data = array();
    protected $type;
    protected $db;
    protected $error = array();

    abstract public function getTitre();
    abstract public function getForm();
    abstract public function isValid(array $data);

    public function __construct(Db $db, $id = null)
    {
        $this->db = $db;

        if(!is_null($id))
            $this->setType('Modifier');
        else
            $this->setType('Ajouter');
    }

    public function populate(array $data)
    {
        $this->data = $data;
    }

    protected function getValue($key)
    {

        if (array_key_exists($key, $this->data))
                return $this->data[$key];

        return null;

    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function addError($key, $val)
    {
        $this->error[$key] = $val;
    }

    public function getError($key)
    {
        
        if (array_key_exists($key, $this->error))
            return $this->error[$key];

        return null;
    }

}