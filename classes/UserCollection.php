<?php
/**
 * @author Denis Fohl
 */
class UserCollection
{

    const HTML_ENTETE = '<th>nom</th><th>email</th><th>actif</th>';

    public static function get(Db $db, array $params = null, array $order = null)
    {

        $result = array();

        $sql = "SELECT u.* FROM user as u WHERE u.email <> 'admin@df-info.com' ORDER BY u.nom";

        $rs = $db->getRowset($sql);
        foreach ($rs as $row) {
            $result[] = new User($row);
        }

        return $result;

    }

    public static function getUser(Db $db, $id)
    {

        $sql = 'SELECT * from user where iduser=' . (int) $id;
        $row = $db->getRow($sql);
        return new User($row);

    }

}