<?php
include_once ('FormAbstract.php');

/**
 * @author Denis Fohl
 */
class FormActuRubrique extends FormAbstract
{

    public function getForm()
    {

        $form   = array();


        $form['libelle'] = '<label for="libelle">libelle</label><input type="text" size="50" id="libelle" name="libelle" value="' . $this->getValue('libelle') . '">';
        if (!is_null($this->getError('titre')))
            $form['titre'] .= '<span class="error">' . $this->getError('titre') . '</span>';

        $form['submit'] = '<label for="submit"></label><input type="submit" id="submit" name="submit" value="' . $this->getType() . '">';

        $result = '<form method="POST">';
        $result .= implode('<br>', $form);
        $result .= '</form>';

        return $result;

    }

    public function getTitre()
    {
        return $this->getType() . ' une rubrique';
    }

    public function isValid(array $data)
    {

        if ($data['libelle'] == '') {
            $this->addError('libelle', 'Veuillez saisir un libelle');
            return false;
        }

        return true;

    }

    public function filter(Db $db, array $data) {

        $data['libelle'] = mysqli_real_escape_string($db->getLink(), $data['libelle']);
        if (array_key_exists('submit', $data))
                unset($data['submit']);

        return $data;

    }

}