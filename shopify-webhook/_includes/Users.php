<?php 

    class Users{

        private $user_id;
        private $first_name;
        private $last_name;
        private $company;
        private $password="xxShopifyy";
        private $password_expires="1970-01-01";
        private $is_active = 1;
        private $is_deleted = 0;

        function set_user_id($user_id){
            $this->user_id = $user_id;
        }

        function set_first_name($first_name){
            $this->first_name = $first_name;
        }

        function set_last_name($last_name){
            $this->last_name = $last_name;
        }

        function set_company($company){
            $this->company = $company;
        }

        function set_password($password){
            $this->password = $password;
        }

        function set_password_expires($password_expires){
            $this->password_expires = $password_expires;
        }

        function set_is_active($is_active){
            $this->is_active = $is_active;
        }

        function set_is_deleted($is_deleted){
            $this->is_deleted = $is_deleted;
        }

        function get_user_id(){
            return $this->user_id;
        }

        function get_first_name(){
            return $this->first_name;
        }

        function get_last_name(){
            return $this->last_name;
        }

        function get_company(){
            return $this->company;
        }

        function get_password(){
            return $this->password;
        }

        function get_password_expires(){
            return $this->password_expires;
        }

        function get_is_active(){
            return $this->is_active;
        }

        function get_is_deleted(){
            return $this->is_deleted;
        }

    }

?>