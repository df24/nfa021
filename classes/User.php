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

    public function __construct($params = null)
    {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $method = 'set' . ucfirst($key);
                $this->$method($value);
            }
        }
    }

    /*******************************************************************************************************************
     * méthodes métier
     */
    public function getNews(array $filters = array())
    {

    }

    public function sendConfirmationEmail()
    {

    }

    public function save($db)
    {

        $data = array(
            'nom'   => $this->getNom(),
            'email' => $this->getEmail(),
            'pwd'   => $this->getPwd(),
            'actif' => $this->getActif()
        );
        if (!is_null($this->getIduser())) {
            $data['iduser'] = $this->getIduser();
        }
        $dataString = implode('\',\'', $data);

        if (array_key_exists('iduser', $data)) {

            $sql = 'UPDATE user SET ';
            foreach ($data as $key => $val)
                $sql .= $key . " = '$val' ";
            $sql .= ' WHERE iduser=' . (int) $data['iduser'];
            return $db->query($sql);

        } else {

            $sql = 'INSERT INTO user (nom, email, pwd, actif) VALUES (\'' . $dataString . '\')';
            return $db->query($sql);

        }

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
        if (is_null($this->actif))
            $this->actif = 'non';
        return $this->actif;
    }

    public function setActif($actif)
    {
        $this->actif = $actif;
    }

}