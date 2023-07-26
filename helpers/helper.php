<?php

    class Helpers {

        static function is_missing(...$fields) {
            $missing = False;

            foreach($fields as $field):
                if (!isset($_REQUEST[$field])):
                    $missing = True;
                    break;
                endif;
            endforeach;

            return $missing;
        }

        static function is_empty(...$fields) {
            $found_empty_field = False;

            foreach($fields as $field):
                if (empty($field)):
                    $found_empty_field = True;
                    break;
                endif;
            endforeach;

            return $found_empty_field;
        }


        /**
         * @param string $fullname
         * @return null when valid
         * @return int 1 invalid characters
         * @return int 2 too short
        */

        static function invalid_fullname($fullname) {
            if (strlen($fullname) >= 6) {
                if (!preg_match("/^[A-Za-z' ]+$/", $fullname)):
                    return 1;
                endif;
            } else {
                return 2;
            }
        }

        static function invalid_group($gruop) {
            if (strlen($gruop) >= 5) {
                if (!preg_match("/^[A-Z0-9]+$/", $gruop)):
                    return 1;
                endif;
            } else {
                return 2;
            }
        }
    
        static function redirect_if_not_authenticated($expected_login, $login_page) {

            if (!isset($_SESSION[$expected_login])) {
                if (isset($_POST["ajax"])) {
                    die("forbidden");
                } else {
                    header("location: index.php?action=$login_page");
                    exit;
                    
                }
            }

        }
    }

?>