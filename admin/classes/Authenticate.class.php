<?php 

    class Authenticate {
        public $appName;
        public $scope;
        public $authFile;
        public $client;

        /**
         * creates a Google_Client object and authenticates it
         * takes an array of authentication options
         * @param array $args
         * items in array include: 
         * string value for $appName,
         * string or array of $scope values, constant values found in Google_Service_Sheets class
         * string $authFile with the path to the authentication file. 
         */
        public function __construct(array $args = [] ) {
            //set object properties with values passed in $args
            foreach($args as $key=>$value) {
                $this->$key = $value;
            }

            //instantiate a new Google_Client object and set properties needed to authenticate client
            $this->client = new Google_Client();
            $this->client->setApplicationName($this->appName);
            $this->client->setScopes($this->scope);
            $this->client->setAuthConfig($this->authFile); 
            $this->client->setAccessType('offline');

        }

        /**
         * returns an authenticated GoogleClient object
         */
        public function returnGoogleClient() {
            return $this->client;
        }
    }
    
?>