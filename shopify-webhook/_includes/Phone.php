

<?php

    class Phone{

        private $usersPhoneID;
        private $userID;
        private $phoneTypeID=1;
        private $phoneNumber;
        private $isDefault=1;

        

        /**
         * Get the value of usersPhoneID
         */ 
        public function getUsersPhoneID()
        {
                return $this->usersPhoneID;
        }

        /**
         * Set the value of usersPhoneID
         *
         * @return  self
         */ 
        public function setUsersPhoneID($usersPhoneID)
        {
                $this->usersPhoneID = $usersPhoneID;

                return $this;
        }

        /**
         * Get the value of userID
         */ 
        public function getUserID()
        {
                return $this->userID;
        }

        /**
         * Set the value of userID
         *
         * @return  self
         */ 
        public function setUserID($userID)
        {
                $this->userID = $userID;

                return $this;
        }

        /**
         * Get the value of phoneTypeID
         */ 
        public function getPhoneTypeID()
        {
                return $this->phoneTypeID;
        }

        /**
         * Set the value of phoneTypeID
         *
         * @return  self
         */ 
        public function setPhoneTypeID($phoneTypeID)
        {
                $this->phoneTypeID = $phoneTypeID;

                return $this;
        }

        /**
         * Get the value of phoneNumber
         */ 
        public function getPhoneNumber()
        {
                return $this->phoneNumber;
        }

        /**
         * Set the value of phoneNumber
         *
         * @return  self
         */ 
        public function setPhoneNumber($phoneNumber)
        {
                $this->phoneNumber = $phoneNumber;

                return $this;
        }

        /**
         * Get the value of isDefault
         */ 
        public function getIsDefault()
        {
                return $this->isDefault;
        }

        /**
         * Set the value of isDefault
         *
         * @return  self
         */ 
        public function setIsDefault($isDefault)
        {
                $this->isDefault = $isDefault;

                return $this;
        }
    }

?>