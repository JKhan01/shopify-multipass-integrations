<?php

    class Address{
        private $address_id;

        private $user_id;
        private $address_type = 1;
        private $address_1;
        private $address_2;
        private $city;
        private $state;
        private $zip;
        private $country;
        private $is_international;
        private $is_default = 1;
        

        /**
         * Get the value of user_id
         */ 
        public function getUser_id()
        {
                return $this->user_id;
        }

        /**
         * Set the value of user_id
         *
         * @return  self
         */ 
        public function setUser_id($user_id)
        {
                $this->user_id = $user_id;

                return $this;
        }

        /**
         * Get the value of address_id
         */ 
        public function getAddress_id()
        {
                return $this->address_id;
        }

        /**
         * Set the value of address_id
         *
         * @return  self
         */ 
        public function setAddress_id($address_id)
        {
                $this->address_id = $address_id;

                return $this;
        }

        /**
         * Get the value of address_type
         */ 
        public function getAddress_type()
        {
                return $this->address_type;
        }

        /**
         * Set the value of address_type
         *
         * @return  self
         */ 
        public function setAddress_type($address_type)
        {
                $this->address_type = $address_type;

                return $this;
        }

        /**
         * Get the value of address_1
         */ 
        public function getAddress_1()
        {
                return $this->address_1;
        }

        /**
         * Set the value of address_1
         *
         * @return  self
         */ 
        public function setAddress_1($address_1)
        {
                $this->address_1 = $address_1;

                return $this;
        }

        /**
         * Get the value of address_2
         */ 
        public function getAddress_2()
        {
                return $this->address_2;
        }

        /**
         * Set the value of address_2
         *
         * @return  self
         */ 
        public function setAddress_2($address_2)
        {
                $this->address_2 = $address_2;

                return $this;
        }

        /**
         * Get the value of city
         */ 
        public function getCity()
        {
                return $this->city;
        }

        /**
         * Set the value of city
         *
         * @return  self
         */ 
        public function setCity($city)
        {
                $this->city = $city;

                return $this;
        }

        /**
         * Get the value of state
         */ 
        public function getState()
        {
                return $this->state;
        }

        /**
         * Set the value of state
         *
         * @return  self
         */ 
        public function setState($state)
        {
                $this->state = $state;

                return $this;
        }

        /**
         * Get the value of zip
         */ 
        public function getZip()
        {
                return $this->zip;
        }

        /**
         * Set the value of zip
         *
         * @return  self
         */ 
        public function setZip($zip)
        {
                $this->zip = $zip;

                return $this;
        }

        /**
         * Get the value of country
         */ 
        public function getCountry()
        {
                return $this->country;
        }

        /**
         * Set the value of country
         *
         * @return  self
         */ 
        public function setCountry($country)
        {
                $this->country = $country;

                return $this;
        }

        /**
         * Get the value of is_international
         */ 
        public function getIs_international()
        {
                return $this->is_international;
        }

        /**
         * Set the value of is_international
         *
         * @return  self
         */ 
        public function setIs_international($is_international)
        {
                $this->is_international = $is_international;

                return $this;
        }

        /**
         * Get the value of is_default
         */ 
        public function getIs_default()
        {
                return $this->is_default;
        }

        /**
         * Set the value of is_default
         *
         * @return  self
         */ 
        public function setIs_default($is_default)
        {
                $this->is_default = $is_default;

                return $this;
        }
    }
?>