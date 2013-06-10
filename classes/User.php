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
    /**
     *
     * @var oui | non
     */
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
    /**
     * Utilisation du package classe Zend_Mail pour pouvoir utiliser un serveur smtp externe car j'ai désactivé
     * la fonction mail sur mon serveur d'hébergement (je n'ai pas installé de serveur smtp dessus)
     *
     * @return boolean
     */
    public function sendConfirmationEmail()
    {

        include_once('Zend/Exception.php');
        include_once('Zend/Mime.php');
        include_once('Zend/Mail.php');
        include_once('Zend/Mail/Transport/Smtp.php');

        $tr = new Zend_Mail_Transport_Smtp('smtp.df-info.com', array(
            'username' => 'smtp@df-info.com',
            'password' => 'pwdbidon24',
            'auth' => 'login'
        ));
        Zend_Mail::setDefaultTransport($tr);

        $mail = new Zend_Mail();
        $url = 'http://' . $_SERVER['SERVER_NAME'] . '/confirm.php?idUser=' . $this->getIduser();
        $mail->setBodyText("Cliquez sur le lien suivant pour valider votre inscription : $url");
        $mail->setFrom('denis.fohl@laposte.net', 'NFA021 - Denis Fohl');
        $mail->addTo($this->getEmail());
        $mail->setSubject('Confirmez votre inscription à PUBLIEZ VOS ACTUS !!!');

        try {
            $mail->send($tr);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }

    /**
     * Sauvegarde l'objet en base
     * Si il existe un id dans l'objet c'est qu'il y a déjà un enregistrement correpondant base => UPDATE
     * sinon => INSERT
     *
     * Si INSERT, on renvoie l'id de l'enregistrement créé en base de données, tableau avec code erreur / message sinon
     *
     * @param Db $db
     * @return interger | array error
     */
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