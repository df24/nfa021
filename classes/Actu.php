<?php
/**
 * @author Denis Fohl
 */
class Actu
{

    protected $idactu;
    protected $titre;
    protected $contenu;
    protected $datePublicationDebut;
    protected $datePublicationFin;
    protected $dateCreation;
    protected $ordre;
    protected $etat;
    protected $idactuRubrique;
    protected $iduser;
    protected $rubrique = 'toLoad';
    protected $user = 'toLoad'; // gestion du lazy loading de l'objet user dans l'objet actu

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

        $dateDebut = $dateFin = $dateCreation = null;

        if (!is_null($this->getDatePublicationDebut()))
            $dateDebut = $this->getDatePublicationDebut()->format('d/m/Y');

        if (!is_null($this->getDatePublicationFin()))
            $dateFin = $this->getDatePublicationFin()->format('d/m/Y');

        if (!is_null($this->getDateCreation()))
            $dateCreation = $this->getDateCreation()->format('d/m/Y');

        return '<td>' . Util::crop($this->getTitre(), 100) . '</td>'
             . '<td>' . $dateDebut . '</td>'
             . '<td>' . $dateFin . '</td>'
             . '<td>' . $dateCreation . '</td>'
             . '<td>' . $this->getOrdre() . '</td>'
             . '<td>' . $this->getEtat() . '</td>'
             . '<td>' . $this->getRubrique($db)->getLibelle() . '</td>';

    }

    public function getCommentaires(Db $db)
    {
        $commentairesLst = CommentaireCollection::get($db, array('idactu' => $this->getId()));
        var_dump($commentairesLst); exit;
        return null;
    }

    public function save($db)
    {

        $data = array(
            'titre'                 => $this->getTitre(),
            'contenu'               => $this->getContenu(),
            'ordre'                 => $this->getOrdre(),
            'datePublicationDebut'  => null,
            'datePublicationFin'    => null,
            'etat'                  => $this->getEtat(),
            'idactuRubrique'        => $this->getIdactuRubrique(),
            'iduser'                => $this->getIduser()
        );

        if (!is_null($this->getDatePublicationDebut()))
            $data['datePublicationDebut'] = $this->getDatePublicationDebut()->format('Y-m-d');

        if (!is_null($this->getDatePublicationFin()))
            $data['datePublicationFin'] = $this->getDatePublicationFin()->format('Y-m-d');

        if (!is_null($this->getIdactu())) {
            $data['idactu'] = $this->getIdactu();
        }


        if (array_key_exists('idactu', $data)) {

            $sql = 'UPDATE actu SET ';
            $values = array();
            foreach ($data as $key => $val) {
                if(!is_null($val) && $val != '')
                    $values[] = $key . " = '$val' ";
            }
            $sql .= implode(', ', $values);
            $sql .= ' WHERE idactu=' . (int) $data['idactu'];

            return $db->query($sql);

        } else {

            $dataString = implode('\',\'', $data);
            $dataString = str_replace("''", 'NULL', $dataString);
            $sql = 'INSERT INTO actu (titre, contenu, ordre, datePublicationDebut, datePublicationFin, etat, idactuRubrique, iduser) VALUES (\'' . $dataString . '\')';
            $result = $db->query($sql);

            if($result === true)
                return mysqli_insert_id($db->getLink());
            else
                return array($db->getLink()->errno => $db->getLink()->error);

        }

    }

    /*******************************************************************************************************************
     * getters et setters
     */

    public function getIdactu()
    {
        return $this->idactu;
    }

    public function getId()
    {
        return $this->getIdactu();
    }

    public function setIdactu($idactu)
    {
        $this->idactu = (int) $idactu;
    }

    public function setId($id) {
        $this->setIdactu($id);
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function getAccroche()
    {
        return $this->accroche;
    }

    public function setAccroche($accroche)
    {
        if ($accroche == '')
            return null;

        $this->accroche = $accroche;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        if ($contenu == '')
            return null;

        $this->contenu = $contenu;
    }

    public function getDatePublicationDebut()
    {
        return $this->datePublicationDebut;
    }

    public function setDatePublicationDebut($datePublicationDebut)
    {
        if ($datePublicationDebut == '')
            return null;

        if (!$datePublicationDebut instanceof DateTime && $datePublicationDebut != '') {
            $datePublicationDebut = new DateTime(Util::ToMysqlDate($datePublicationDebut) . '00:00');
        }
        $this->datePublicationDebut = $datePublicationDebut;

    }

    public function getDatePublicationFin()
    {
        return $this->datePublicationFin;
    }

    public function setDatePublicationFin($datePublicationFin)
    {

        if ($datePublicationFin == '')
            return null;

        if (!$datePublicationFin instanceof DateTime) {
            $datePublicationFin = new DateTime(Util::ToMysqlDate($datePublicationFin) . '23:59');
        }
        $this->datePublicationFin = $datePublicationFin;

    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setDateCreation($dateCreation)
    {
        if (!$dateCreation instanceof DateTime) {
            $dateCreation = new DateTime(Util::ToMysqlDate($dateCreation));
        }
        $this->dateCreation = $dateCreation;
    }

    public function getOrdre()
    {
        return $this->ordre;
    }

    public function setOrdre($ordre)
    {
        if($ordre == null)
            return null;

        $this->ordre = $ordre;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($etat)
    {
        if ($etat == null)
            return null;

        $this->etat = $etat;
    }

    public function getIdactuRubrique()
    {
        return $this->idactuRubrique;
    }

    public function setIdactuRubrique($idactuRubrique)
    {
        $this->idactuRubrique = $idactuRubrique;
    }

    public function getIduser()
    {
        return $this->iduser;
    }

    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    public function getRubrique(Db $db)
    {
        // lazy loading de l'objet user dans l'objet actu
        if ($this->rubrique == 'toLoad') {
            $sql = 'SELECT libelle FROM actuRubrique WHERE idactuRubrique =' . $this->getIdactuRubrique();
            $row = $db->getRow($sql);
            $this->rubrique = new ActuRubrique($row);
        }

        return $this->rubrique;
    }

    public function setRubrique($rubrique)
    {
        $this->rubrique = $rubrique;
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