<?php
/**
 * Description of User
 *
 * @author Denis Fohl
 */
class User
{
    /**
     *
     * @var int
     */
    protected $iduser;
    /**
     *
     * @var string
     */
    protected $nom;
    /**
     *
     * @var string
     */
    protected $email;
    /**
     *
     * @var string
     */
    protected $pwd;
    /**
     *
     * @var string
     */
    protected $pseudo;
    protected $actif;
    /**
     *
     * @var News[]
     */
    protected $news;

    public function __construct(array $values = array())
    {
        foreach ($values as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

    /*******************************************************************************************************************
     * méthodes métier
     */
    public function getNews(array $filters = array())
    {

    }

    /*******************************************************************************************************************
     * getters et setters
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPwd()
    {
        return $this->pwd;
    }

    public function setPwd($pwd)
    {
        $this->pwd = $pwd;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getActif()
    {
        return $this->actif;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
    }

}