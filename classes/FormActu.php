<?php
include_once ('FormAbstract.php');

/**
 * @author Denis Fohl
 */
class FormActu extends FormAbstract
{

    protected $rubriques = array();

    public function __construct(Db $db, $id = null)
    {

        parent::__construct($db, $id);

        $data = ActuRubriqueCollection::get($this->db, array('iduser' => $_SESSION['user']->getIduser()));
        $this->rubriques = '<label for="rubrique">rubrique</label>';
        $this->rubriques .= '<SELECT name="idactuRubrique" id="idactuRubrique">';
        foreach ($data as $key => $val) {
            $this->rubriques .= '<OPTION value="' . $key . '">' . $val->getLibelle() . '</OPTION>';
        }
        $this->rubriques .= '</SELECT>';


    }

    public function getForm()
    {

        $form   = array();

        $form['rub'] = $this->rubriques;

        $form['titre'] = '<label for="titre">titre</label><textarea cols="45" rows="3" id="titre" name="titre">' . $this->getValue('titre') . '</textarea>';
        if (!is_null($this->getError('titre')))
            $form['titre'] .= '<span class="error">' . $this->getError('titre') . '</span>';

        $form['contenu'] = '<label for="contenu">contenu</label><textarea cols="45" rows="3" id="contenu" name="contenu">' . $this->getValue('contenu') . '</textarea>';

        $form['datePublicationDebut'] = '<label for="datePublicationDebut">date de publication début</label><input size="15" type="text" id="datePublicationDebut" name="datePublicationDebut" value="' . Util::ToFrDate($this->getValue('datePublicationDebut')) . '">';
        if (!is_null($this->getError('datePublicationDebut')))
            $form['datePublicationDebut'] .= '<span class="error">' . $this->getError('datePublicationDebut') . '</span>';

        $form['datePublicationFin'] = '<label for="datePublicationFin">date de publication fin</label><input size="15" type="text" id="datePublicationFin" name="datePublicationFin" value="' . Util::ToFrDate($this->getValue('datePublicationFin')) . '">';
        if (!is_null($this->getError('datePublicationFin')))
            $form['datePublicationFin'] .= '<span class="error">' . $this->getError('datePublicationFin') . '</span>';

        $brouillon = 'checked';
        $valid = null;
        if ($this->getValue('etat') == 'valid') {
            $brouillon = null;
            $valid = 'checked';
        }
        $form['etat'] = '<label for="etat">état</label><input type="radio" id="etat" name="etat" value="brouillon" ' . $brouillon . '>brouillon<input type="radio" id="etat" name="etat" value="valid" ' . $valid . '>publiée';

        $form['ordre'] = '<label for="ordre">ordre</label><input size="4" type="text" id="ordre" name="ordre" value="' . $this->getValue('ordre') . '">';
        if (!is_null($this->getError('ordre')))
            $form['ordre'] .= '<span class="error">' . $this->getError('ordre') . '</span>';

        $form['submit'] = '<label for="submit"></label><input type="submit" id="submit" name="submit" value="' . $this->getType() . '">';

        $result = '<form method="POST">';
        $result .= implode('<br>', $form);
        $result .= '</form>';

        return $result;

    }

    public function getTitre()
    {
        return $this->getType() . ' une actualité';
    }

    public function isValid(array $data)
    {

        if ($data['titre'] == '') {
            $this->addError('titre', 'Veuillez saisir un titre');
            return false;
        }

        if ($data['datePublicationDebut'] != '') {
            if (!preg_match('`^\d{2}/\d{2}/\d{4}$`', $data['datePublicationDebut'])) {
               $this->addError('datePublicationDebut', 'Veuillez saisir une date de début au format jj/mm/aaaa');
               return false;
            }
        } else {
            $this->addError('datePublicationDebut', 'Veuillez saisir une date de début de publication');
            return false;
        }

        if ($data['datePublicationFin'] != '') {
            if (!preg_match('`^\d{1,2}/\d{1,2}/\d{4}$`', $data['datePublicationFin'])) {
               $this->addError('datePublicationFin', 'Veuillez saisir une date de fin au format jj/mm/aaaa');
               return false;
            }
        } else {
            $this->addError('datePublicationFin', 'Veuillez saisir une date de fin de publication');
            return false;
        }

        if ($data['ordre'] != '') {
            if (!preg_match('#[[:digit:]]#', $data['ordre'])) {
               $this->addError('ordre', 'Veuillez saisir un numéro d\'ordre numérique');
               return false;
            }
        }

        return true;

    }

    public function filter(Db $db, array $data) {

        $data['titre'] = mysqli_real_escape_string($db->getLink(), $data['titre']);
        $data['contenu'] = mysqli_real_escape_string($db->getLink(), $data['contenu']);
        $data['idactuRubrique'] = (int) $data['idactuRubrique'];
        $data['ordre'] = (int) $data['ordre'];
        if ($data['etat'] != 'brouillon' && $data['etat'] != 'valid')
            $data['etat'] = 'brouillon';

        return $data;
    }

}