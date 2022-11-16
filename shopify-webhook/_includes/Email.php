

<?php

    class Email{

        private $usersEmailID;
        private $usersID;
        private $emailAddress;
        private $emailsTypeID=1;
        private $isDefault = 1;
        private $optIn = 1;

        /**
         * Get the value of usersEmailID
         */ 
        public function getUsersEmailID()
        {
                return $this->usersEmailID;
        }

        /**
         * Set the value of usersEmailID
         *
         * @return  self
         */ 
        public function setUsersEmailID($usersEmailID)
        {
                $this->usersEmailID = $usersEmailID;

                return $this;
        }

        /**
         * Get the value of usersID
         */ 
        public function getUsersID()
        {
                return $this->usersID;
        }

        /**
         * Set the value of usersID
         *
         * @return  self
         */ 
        public function setUsersID($usersID)
        {
                $this->usersID = $usersID;

                return $this;
        }

        /**
         * Get the value of emailAddress
         */ 
        public function getEmailAddress()
        {
                return $this->emailAddress;
        }

        /**
         * Set the value of emailAddress
         *
         * @return  self
         */ 
        public function setEmailAddress($emailAddress)
        {
                $this->emailAddress = $emailAddress;

                return $this;
        }

        /**
         * Get the value of emailsTypeID
         */ 
        public function getEmailsTypeID()
        {
                return $this->emailsTypeID;
        }

        /**
         * Set the value of emailsTypeID
         *
         * @return  self
         */ 
        public function setEmailsTypeID($emailsTypeID)
        {
                $this->emailsTypeID = $emailsTypeID;

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

        /**
         * Get the value of optIn
         */ 
        public function getOptIn()
        {
                return $this->optIn;
        }

        /**
         * Set the value of optIn
         *
         * @return  self
         */ 
        public function setOptIn($optIn)
        {
                $this->optIn = $optIn;

                return $this;
        }
    }

?>
