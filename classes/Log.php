<?php
/**
 * @author Denis Fohl
 */
class Log
{

    protected $id;
    protected $stamp;
    protected $type;
    protected $iduser;
    protected $user = 'toLoad'; // gestion du lazy loading de l'objet user dans l'objet actu

    /*******************************************************************************************************************
     * méthodes métier
     */
    public function __construct(array $values = array())
    {

        foreach ($values as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }

    }

    public function toHtmlTd(Db $db)
    {

        $stamp = null;

        if (!is_null($this->getStamp()))
            $stamp = $this->getStamp()->format('d/m/Y H:i');

        return '<td>' . $stamp . '</td>'
             . '<td>' . $this->getType() . '</td>'
             . '<td>' . $this->getUser($db)->getNom() . '</td>';

    }

    public function save($db)
    {

        $data = array(
            'type'   => $this->getType(),
            'iduser' => $this->getIduser()
        );


        $dataString = implode('\',\'', $data);
        $dataString = str_replace("''", 'NULL', $dataString);
        $sql = 'INSERT INTO log (type, iduser) VALUES (\'' . $dataString . '\')';
        $result = $db->query($sql);

        if($result === true)
            return mysqli_insert_id($db->getLink());
        else
            return array($db->getLink()->errno => $db->getLink()->error);


    }

    /*******************************************************************************************************************
     * getters et setters
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getStamp()
    {
        return $this->stamp;
    }

    public function setStamp($stamp)
    {

        $this->stamp = new DateTime($stamp);

    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }


    public function getIduser()
    {
        return $this->iduser;
    }

    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    public function getUser(Db $db)
    {
        // lazy loading de l'objet user dans l'objet actu
        if ($this->user == 'toLoad') {
            $sql = 'SELECT nom, email, actif FROM user WHERE iduser =' . $this->getIduser();
            $userRow = $db->getRow($sql);
            $this->user = new User($userRow);
        }

        return $this->user;

    }

    public function setUser($user)
    {
        $this->user = $user;
    }

}