<?php
/**
 * @author Denis Fohl
 */
class Actu
{

    protected $idactu;
    protected $titre;
    protected $accroche;
    protected $contenu;
    protected $datePublicationDebut;
    protected $datePublicationFin;
    protected $dateCreation;
    protected $ordre;
    protected $etat;
    protected $visibilite;
    protected $idactuRubrique;
    protected $iduser;
    protected $rubrique;
    protected $user = 'toLoad'; // gestion du lazy loading de l'objet user dans l'objet actu

    public function __construct(array $values = array())
    {

        foreach ($values as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }

    }

    public function getIdactu()
    {
        return $this->idactu;
    }

    public function setIdactu($idactu)
    {
        $this->idactu = $idactu;
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
        $this->accroche = $accroche;
    }

    public function getContenu()
    {
        return $this->contenu;
    }

    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    public function getDatePublicationDebut()
    {
        return $this->datePublicationDebut;
    }

    public function setDatePublicationDebut($datePublicationDebut)
    {
        if (!$datePublicationDebut instanceof DateTime) {
            $datePublicationDebut = new DateTime($datePublicationDebut);
        }
        $this->datePublicationDebut = $datePublicationDebut;
    }

    public function getDatePublicationFin()
    {
        return $this->datePublicationFin;
    }

    public function setDatePublicationFin($datePublicationFin)
    {
        if (!$datePublicationFin instanceof DateTime) {
            $datePublicationFin = new DateTime($datePublicationFin);
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
            $dateCreation = new DateTime($dateCreation);
        }
        $this->dateCreation = $dateCreation;
    }

    public function getOrdre()
    {
        return $this->ordre;
    }

    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;
    }

    public function getEtat()
    {
        return $this->etat;
    }

    public function setEtat($etat)
    {
        $this->etat = $etat;
    }

    public function getVisibilite()
    {
        return $this->visibilite;
    }

    public function setVisibilite($visibilite)
    {
        $this->visibilite = $visibilite;
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

    public function getRubrique()
    {
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