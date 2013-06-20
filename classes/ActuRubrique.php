<?php
/**
 * @author Denis Fohl
 */
class ActuRubrique
{

    protected $idactuRubrique;
    protected $libelle;
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

    public function toHtmlTd()
    {
        return '<td>' . Util::crop($this->getLibelle(), 140) . '</td>';
    }

    public function save($db)
    {

        $data = array(
            'libelle'   => $this->getLibelle(),
            'iduser'    => $this->getIduser()
        );

        if (!is_null($this->getId())) {
            $data['idactuRubrique'] = $this->getId();
        }

        if (array_key_exists('idactuRubrique', $data)) {

            $sql = 'UPDATE actuRubrique SET ';
            $values = array();
            foreach ($data as $key => $val) {
                if(!is_null($val) && $val != '')
                    $values[] = $key . " = '$val' ";
            }
            $sql .= implode(', ', $values);
            $sql .= ' WHERE idactuRubrique=' . (int) $data['idactuRubrique'];

            return $db->query($sql);

        } else {

            $dataString = implode('\',\'', $data);
            $dataString = str_replace("''", 'NULL', $dataString);
            $sql = 'INSERT INTO actuRubrique (libelle, iduser) VALUES (\'' . $dataString . '\')';
            $result = $db->query($sql);

            if($result === true)
                return mysqli_insert_id($db->getLink());
            else
                return array($db->getLink()->errno => $db->getLink()->error);

        }

    }

    public function getId()
    {
        return $this->getIdactuRubrique();
    }
    
    public function setId($id)
    {
        $this->setIdactuRubrique($id);
    }

    /*******************************************************************************************************************
     * getters et setters
     */
    public function getIdactuRubrique()
    {
        return $this->idactuRubrique;
    }

    public function setIdactuRubrique($idactuRubrique)
    {
        $this->idactuRubrique = $idactuRubrique;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
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