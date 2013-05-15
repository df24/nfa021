<?php
/**
 *
 * @author Denis Fohl
 */
class ActuCollection
{

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
        }

        $sql .= ' WHERE ' . implode(' AND ', $where);

        if (is_array($order)) {
            $sql .= ' ORDER BY ' . implode(', ', $order);
        } else {
            $sql .= ' ORDER BY a.dateCreation DESC';
        }
//        var_dump($sql);
        $rs = $db->getRowset($sql);
        foreach ($rs as $row) {
            $result[] = new Actu($row);
        }

        return $result;

    }

}