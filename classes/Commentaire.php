<?php
/**
 * @author Denis Fohl
 */
class Commentaire
{

    protected $idcommentaire;
    protected $commentaire;
    protected $date;
    protected $iduser;
    protected $user = 'toLoad'; // gestion du lazy loading de l'objet user dans l'objet actu
    protected $idactu;
    protected $actu = 'toLoad';

    /*******************************************************************************************************************
     * méthodes métier
     */
    public function __construct(array $values = array())
    {

        foreach ($values as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method))
                $this->$method($value);
        }

    }

    public function toHtmlTd(Db $db)
    {

        $date = null;

        if (!is_null($this->getDate()))
            $date = $this->getDate()->format('d/m/Y');

        return '<td>' . $date . '</td>'
             . '<td>' . Util::crop($this->getCommentaire(), 140) . '</td>'
             . '<td>' . Util::crop($this->getActu($db)->getTitre(), 140) . '</td>';

    }

    public function toHtmlTdSimple(Db $db)
    {

        $date = null;

        if (!is_null($this->getDate()))
            $date = $this->getDate()->format('d/m/Y');

        return '<td>' . $date . '</td>'
             . '<td>' . Util::crop($this->getCommentaire(), 140) . '</td>'
             . '<td>' . $this->getUser($db)->getNom() . '</td>';

    }

    public function save($db)
    {

        $data = array(
            'commentaire'=> $this->getCommentaire(),
            'idactu' => $this->getIdactu(),
            'iduser' => $this->getIduser()
        );

        if (!is_null($this->getDate()))
            $data['date'] = $this->getDate()->format('Y-m-d');

        if (!is_null($this->getId())) {
            $data['idcommentaire'] = $this->getId();
        }


        if (array_key_exists('idcommentaire', $data)) {

            $sql = 'UPDATE commentaire SET ';
            $values = array();
            foreach ($data as $key => $val) {
                if(!is_null($val) && $val != '')
                    $values[] = $key . " = '$val' ";
            }
            $sql .= implode(', ', $values);
            $sql .= ' WHERE idcommentaire=' . (int) $data['idcommentaire'];

            return $db->query($sql);

        } else {

            $dataString = implode('\',\'', $data);
            $dataString = str_replace("''", 'NULL', $dataString);
            $sql = 'INSERT INTO commentaire (commentaire, idactu, iduser) VALUES (\'' . $dataString . '\')';
//var_dump($sql);
//exit;
            $result = $db->query($sql);

            if($result === true)
                return mysqli_insert_id($db->getLink());
            else
                return array($db->getLink()->errno => $db->getLink()->error);

        }

    }

    public function getId()
    {
        return $this->getIdcommentaire();
    }

    public function setId($id)
    {
        $this->setIdcommentaire($id);
    }

    /*******************************************************************************************************************
     * getters et setters
     */
    public function getIdcommentaire()
    {
        return $this->idcommentaire;
    }

    public function setIdcommentaire($idcommentaire)
    {
        $this->idcommentaire = (int) $idcommentaire;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    public function getDate()
    {
        return $this->date;
    }

    public function setDate($date)
    {

        if ($date == '')
            return null;

        if (!$date instanceof DateTime && $date != '') {
            $date = new DateTime(Util::ToMysqlDate(substr($date, 0, 10)) . '00:00');
        }
        $this->date = $date;

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

        // lazy loading de l'objet user dans l'objet commentaire
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

    public function getIdactu()
    {
        return $this->idactu;
    }

    public function setIdactu($idactu)
    {
        $this->idactu = $idactu;
    }

    public function getActu(Db $db)
    {
        // lazy loading de l'objet actu dans l'objet commentaire
        if ($this->actu == 'toLoad') {
            $sql = 'SELECT * FROM actu WHERE idactu =' . $this->getIdactu();
            $actuRow = $db->getRow($sql);
            $this->actu = new Actu($actuRow);
        }

        return $this->actu;
    }

    public function setActu($actu)
    {
        $this->actu = $actu;
    }

}