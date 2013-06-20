<?php
/**
 * @author Denis Fohl
 */
class ActuCollection
{

    const TXT_ADD = 'Ajoutez une actualité';
    const HTML_ENTETE = '<th>actu</th><th>début</th><th>fin</th><th>création</th><th>ordre</th><th>Workflow</th><th>Rubrique</th>';

    public static function get(Db $db, array $params = null, array $order = null)
    {

        $result = array();

        $sql = 'SELECT a.* FROM actu as a, user as u';

        $where = array();
        $where[] = 'a.iduser = u.iduser AND u.actif = \'oui\'';

        if (is_array($params)) {
            if (array_key_exists('iduser', $params)) {
                    $where[] = 'a.iduser = ' . (int) $params['iduser'];
            }
            if (array_key_exists('idactuRubrique', $params)) {
                    $where[] = 'a.idactuRubrique = ' . (int) $params['idactuRubrique'];
            }
            if (array_key_exists('dateConsultation', $params)) {
                    $where[] = 'a.datePublicationDebut <= \'' . $params['dateConsultation'] . '\' AND a.datePublicationFin >= \'' . $params['dateConsultation']  . '\' AND a.etat=\'valid\'';
            }
            if (array_key_exists('etat', $params)) {
                    $etat = $params['etat'];
                    $where[] = 'a.etat = \'' . $etat . '\'';
            }
        }

        $sql .= ' WHERE ' . implode(' AND ', $where);

        if (is_array($order)) {
            $sql .= ' ORDER BY ' . implode(', ', $order);
        } else {
            $sql .= ' ORDER BY a.dateCreation DESC';
        }
//var_dump($sql);
        $rs = $db->getRowset($sql);
        foreach ($rs as $row) {
            $result[] = new Actu($row);
        }

        return $result;

    }

    public static function getActu(Db $db, $id)
    {

        $sql = 'SELECT * from actu where idactu=' . (int) $id;
        $row = $db->getRow($sql);
        return new Actu($row);

    }

    public static function getRow(Db $db, $id)
    {

        $sql = 'SELECT * from actu where idactu=' . (int) $id;

        $row = mysqli_query($db->getLink(), $sql);

        if ($row === false)
            return null;

        return mysqli_fetch_assoc($row);

    }

    public static function del(Db $db, $id)
    {
        $sql = 'DELETE FROM actu WHERE idactu = ' . (int) $id;
        mysqli_query($db->getLink(), $sql);
    }

}