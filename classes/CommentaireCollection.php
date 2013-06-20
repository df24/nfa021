<?php
/**
 * @author Denis Fohl
 */
class CommentaireCollection
{

    const TXT_ADD = 'Ajoutez un commentaire';
    const HTML_ENTETE = '<th>date</th><th>commentaire</th><th>actu</th>';

    public static function get(Db $db, array $params = null, array $order = null)
    {

        $result = array();

        $sql = 'SELECT c.* FROM commentaire as c, user as u, actu as a';

        $where = array();
        $where[] = 'c.idactu = a.idactu AND c.iduser = u.iduser AND u.actif = \'oui\'';

        if (is_array($params)) {
            if (array_key_exists('iduser', $params)) {
                    $where[] = 'c.iduser = ' . (int) $params['iduser'];
            }
            if (array_key_exists('idactu', $params)) {
                    $where[] = 'c.idactu = ' . (int) $params['idactu'];
            }
        }

        $sql .= ' WHERE ' . implode(' AND ', $where);

        if (is_array($order)) {
            $sql .= ' ORDER BY ' . implode(', ', $order);
        } else {
            $sql .= ' ORDER BY c.date DESC';
        }
//var_dump($sql);
        $rs = $db->getRowset($sql);
        foreach ($rs as $row) {
            $result[] = new Commentaire($row);
        }

        return $result;

    }

    public static function getCommentaire(Db $db, $id)
    {

        $sql = 'SELECT * from commentaire where idcommentaire=' . (int) $id;
        $row = $db->getRow($sql);
        return new Commentaire($row);

    }

    public static function getRow(Db $db, $id)
    {

        $sql = 'SELECT * from commentaire where idcommentaire=' . (int) $id;

        $row = mysqli_query($db->getLink(), $sql);

        if ($row === false)
            return null;

        return mysqli_fetch_assoc($row);

    }

    public static function del(Db $db, $id)
    {
        $sql = 'DELETE FROM commentaire WHERE idcommentaire = ' . (int) $id;
        mysqli_query($db->getLink(), $sql);
    }

}