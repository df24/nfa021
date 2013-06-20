<?php
include_once ('FormAbstract.php');

/**
 * @author Denis Fohl
 */
class FormCommentaire extends FormAbstract
{

    public function getForm()
    {

        $form   = array();

        $form['commentaire'] = '<label for="commentaire">commentaire</label><textarea cols="45" rows="3" id="commentaire" name="commentaire">' . $this->getValue('commentaire') . '</textarea>';
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
        return $this->getType() . ' un commentaire';
    }

    public function isValid(array $data)
    {

        if ($data['commentaire'] == '') {
            $this->addError('titre', 'Veuillez saisir un commentaire');
            return false;
        }

        return true;

    }

    public function filter(Db $db, array $data) {

        $data['commentaire'] = mysqli_real_escape_string($db->getLink(), $data['commentaire']);
        if (array_key_exists('submit', $data))
                unset($data['submit']);
        return $data;
    }

}