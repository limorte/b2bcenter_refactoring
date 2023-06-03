<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/db.php";
/**
 * @link    https://github.com/limorte/b2bcenter_refactoring
 * @author  Nikita Gorelov <limorte@me.com>
 * @version 0.1
 *
 * Задание №1
 * SELECT users.name, COUNT(phone_numbers.phone) as phone_count FROM users LEFT JOIN phone_numbers ON phone_numbers.user_id = users.id
 * WHERE users.gender = 2 AND users.birth_date < UNIX_TIMESTAMP(NOW() - INTERVAL 18 year) AND users.birth_date > UNIX_TIMESTAMP(NOW() - INTERVAL 22 year)
 * GROUP BY users.name;
 *
 * Задание №2
 * В исходном коде не было проверки ошибки подключения к базе, не было проверки $_GET на наличие.
 * Не рационально делать множество запросов к бд в цикле, можно получить данные в один запрос.
 * Из уязвимостей: не рекомендуется хранить реквизиты базы данных в коде, должна быть экранизация $_GET.
 * Так же не рекомендуется использовать html внутри php (MVC).
 * Не выводилось сообщение если пользователи с данными id отсутствуют.
 *

 *
 * Class Users
 */
class Users
{
    /**
     * @param array $user_ids
     * @return array
     */
    public function load_users_data(array $user_ids): array
    {
        $data = [];
        $db = $this->db_connect();
        $query = "SELECT * FROM users WHERE " . $this->ids_for_query($user_ids);
        $sql = mysqli_query($db, $query);
        while ($obj = $sql->fetch_object()) {
            $data[$obj->id] = $obj->name;
        }
        $db->close();
        return $data;
    }

    /**
     * @return mysqli
     */
    public function db_connect(): mysqli
    {
        $db = new DB();
        try {
            $db = new mysqli($db->host, $db->user, $db->pass, $db->name);
        } catch (Exception $e) {
            echo "Ошибка! Чтото не так с MySQL: ", $e->getMessage(), "\n";
            die();
        }
        if ($db->connect_errno) {
            die("Ошибка! Чтото не так с MySQL: " . $this->db->connect_error);
        }
        return $db;
    }

    /**
     * @param $arr
     * @return string
     */
    public function ids_for_query($arr): string
    {
        $str_ids = "";
        foreach ($arr as $user_id) {
            $str_ids .= " id = " . $user_id . " OR";
        }
        return substr($str_ids, 0, -2);
    }

    /**
     * @param $str
     * @return array
     */
    public function ids_to_array($str): array
    {
        $str = preg_replace("/[^,0-9]/", "", $str);
        $arr = explode(",", $str);
        $arr = array_filter($arr);
        if (count($arr) < 1) {
            die("Ошибка! В параметре user_ids отсутвуют идентификаторы");
        }
        return $arr;
    }

    /**
     * Функция делает это
     *
     * @return void
     */
    public function print_users_data(): void
    {
        if (!isset($_GET["user_ids"])) {
            die("Ошибка! Параметр user_ids не задан");
        }
        $ids = $this->ids_to_array($_GET["user_ids"]);
        $data = $this->load_users_data($ids);
        if (count($data) < 1) {
            echo "Ни одного пользователя не найдено";
        }
        foreach ($data as $user_id => $name) {
            echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
        }
    }
}
