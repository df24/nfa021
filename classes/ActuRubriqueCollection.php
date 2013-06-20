<?php
/**
 * @author Denis Fohl
 */
class ActuRubriqueCollection
{

    const TXT_ADD = 'Ajoutez une rubrique';
    const HTML_ENTETE = '<th>Libellé</th>';

    public static function get(Db $db, array $params = null, array $order = null)
    {

        $result = array();

        $sql = 'SELECT a.* FROM actuRubrique as a, user as u';

        $where = array();
        $where[] = 'a.iduser = u.iduser AND u.actif = \'oui\'';

        if (is_array($params)) {
            if (array_key_exists('iduser', $params)) {
                    $where[] = 'a.iduser = ' . (int) $params['iduser'];
            }
        }

        $sql .= ' WHERE ' . implode(' AND ', $where);

        if (is_array($order)) {
            $sql .= ' ORDER BY ' . implode(', ', $order);
        } else {
            $sql .= ' ORDER BY a.libelle';
        }
//var_dump($sql);
        $rs = $db->getRowset($sql);
        foreach ($rs as $row) {
            $result[$row['idactuRubrique']] = new ActuRubrique($row);
        }

        return $result;

    }

    public static function getActuRubrique(Db $db, $id)
    {

        $sql = 'SELECT * from actuRubrique where idactuRubrique=' . (int) $id;
        $row = $db->getRow($sql);
        return new ActuRubrique($row);

    }

    public static function getRow(Db $db, $id)
    {

        $sql = 'SELECT * from actuRubrique where idactuRubrique=' . (int) $id;

        $row = mysqli_query($db->getLink(), $sql);

        if ($row === false)
            return null;

        return mysqli_fetch_assoc($row);

    }

    public static function del(Db $db, $id)
    {
        $sql = 'DELETE FROM actuRubrique WHERE idactuRubrique = ' . (int) $id;
        mysqli_query($db->getLink(), $sql);
    }

}