<?php
/**
 * @author Denis Fohl
 */
class LogCollection
{

    const HTML_ENTETE = '<th>date</th><th>action</th><th>utilisateur</th>';

    public static function get(Db $db, array $params = null, array $order = null)
    {

        $result = array();

        $sql = 'SELECT l.* FROM log as l, user as u';

        $where = array();
        $where[] = 'l.iduser = u.iduser';

        if (is_array($params)) {
            if (array_key_exists('iduser', $params) && $params['iduser'] != '1') {
                    $where[] = 'a.iduser = ' . (int) $params['iduser'];
            }
        }

        $sql .= ' WHERE ' . implode(' AND ', $where);

        if (is_array($order)) {
            $sql .= ' ORDER BY ' . implode(', ', $order);
        } else {
            $sql .= ' ORDER BY l.stamp DESC';
        }
        $rs = $db->getRowset($sql);
        foreach ($rs as $row) {
            $result[] = new Log($row);
        }

        return $result;

    }

    public static function getLog(Db $db, $id)
    {

        $sql = 'SELECT * from log where id=' . (int) $id;
        $row = $db->getRow($sql);
        return new Log($row);

    }

    public static function getRow(Db $db, $id)
    {

        $sql = 'SELECT * from log where id=' . (int) $id;

        $row = mysqli_query($db->getLink(), $sql);

        if ($row === false)
            return null;

        return mysqli_fetch_assoc($row);

    }

    public static function write(Db $db, User $user, $type)
    {
        $log = new Log(array(
            'idUser' => $user->getIduser(),
            'type'   => $type
        ));
        $log->save($db);
    }

}