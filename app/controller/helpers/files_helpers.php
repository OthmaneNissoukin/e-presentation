<?php

    class FilesHelper {

        static function create_file_if_not_exist($file_path) {
            if (!file_exists($file_path)):
                mkdir($file_path);
            endif;
        }

        static function remove_file_if_exists($file_path) {
            if (file_exists($file_path)):
                unlink($file_path);
            endif;
        }

    }

?>