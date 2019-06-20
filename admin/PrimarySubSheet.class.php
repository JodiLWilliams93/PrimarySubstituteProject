<?php 

    /**
     * create a class that will handle the methods for the primary spreadsheet
     */
    class PrimarySubSheet {

        //spreadsheetID found in google sheets url string between /d/ and /edit
        public $spreadsheetID;
        //values to use as keys for columns
        public $keys;
        //
        public $sheetID;
        //found on the sheet tab in google tabs
        public $sheetName;
        //cells to edit or retrieve
        public $range = '';
        //holder for Google_Service_Sheets object
        public $service;
        //array with all substitutes
        public $subList;
        //column on the sheet with the dates last subbed
        public $lastSubbedColumn = 'J';
        //array with callings that do not require a specific gender
        public $ignoreGender = ['Lead the music', 'Play the piano'];
       //holder for subs sorted into 5 categories based on how well they match criteria
        public $subListSorted = [ 1=>[], 2=>[], 3=>[], 4=>[], 5=>[] ];
        //ensures that only one sheet is created and returns same sheet if another instance is called
        private static $instance;

       
        private function __construct($info) {
            //loop through each item in $info and store as object properties
            foreach ($info as $key => $value) {
                $this->$key = $value; 
            }
           
            //define authentication file
            $authFile =  ADMIN . '/authentication/credentials.json';

            //create array with properties for authenticating with Google Sheets API
            $authenticateParam =[
                'appName' => 'Primary Substitutes',
                'authFile' => $authFile,
                'scope' => Google_Service_Sheets::SPREADSHEETS
            ];
            
            //create new Authenticate object and return the Google Client object to use in creating a service object
            $client = new Authenticate($authenticateParam);
            $client = $client->returnGoogleClient();

            //create Google_Service_Sheets object using Google_Client
            $service = new Google_Service_Sheets($client);
            
            $this->service = $service;

        }

        public static function getInstance(array $info=[]) {
            //check if an $instance has been saved if not, create a new PrimarySubSheet
            if(!isset(self::$instance)) {
                self::$instance = new PrimarySubSheet($info);
            }
            //if an instance is saved, return that instance. 
            return self::$instance;
        }

        public function createSubList() {
            //gets all values from the table- comes in an array of arrays 
            $response = $this->service->spreadsheets_values->get($this->spreadsheetID, $this->sheetName);
            $rows = $response->getValues();

            //for all the rows except the first one with form questions
            for ($i=1; $i < count($rows); $i++) { 
                //set row value
                $sub['row'] = $i + 1;
                //for each column make an associative array with $this->key values and sheet values
                for ($j=0; $j < count($this->keys); $j++) { 
                    $sub[$this->keys[$j]] = $rows[$i][$j] ?? null;
                }
                //Create a Substitute object and add it to a master sublist.
                $subList[] = new Substitute($sub); 
            }
            //save subList to this object.
            $this->subList = $subList;
        }

        public function findSubByRow($row){
            //set range to return entire row
            $range = "{$this->sheetName}!A{$row}:J{$row}";
            //get data from that row
            $response = $this->service->spreadsheets_values->get($this->spreadsheetID, $range);
            $rows = $response->getValues();
            
            //map data to $keys
            for ($i=0; $i < count($this->keys); $i++) { 
                $sub[$this->keys[$i]] = $rows[0][$i] ?? '';
            }
            //create and return a Substitute object with those properties.
            $substitute = new Substitute($sub);
            $substitute->row = $row;
            return $substitute;

        }

        /**
         * takes in string values to match for gender, date, and willing
         * loops through each sub in the sublist array from createSubList() method
         * returns an array with subs matching the filter criteria
         */
        public function filterSubsBy(string $gender=null, string $date=null, string $willing=null) {
            
            //check if the sub is needed for a music calling since gender won't matter for those positions
            $this->music =  in_array($willing, $this->ignoreGender) !== false;

            //loop through subs to see how well they match criteria
            foreach ($this->subList as $sub) {
                //set $sub->timeFromSub using the selected date
                $sub->timeFromSub($date);
                //check if available and willing to cover the position specified
                $conditions = $sub->available($date) && $sub->willing($willing);
                
                //if not a music calling and sub is available and willing, check if gender matches.
                if(!$this->music) {
                    $conditions = $conditions && ($gender == $sub->gender);
                } //if a music calling gender doesn't matter so don't consider in conditions
                
                //if the sub matches all the above criteria
                if($conditions) { 
                    if($sub->timeFromSub >= 6){
                        //if 6 or more weeks since the sub subbed add to fiveStar list
                        $this->subListSorted[5][] = $sub;
                    } else if ($sub->timeFromSub >= 4) {
                        //if 4-6 weeks since the sub subbed add to fourStar list
                        $this->subListSorted[4][] = $sub;
                    } else {
                        //if less than weeks since the sub subbed add to fourStar list
                        $this->subListSorted[3][] = $sub;
                    }
                } else if ($sub->willing($willing) && ($sub->gender == $gender || $this->music)) {
                    //if sub doesn't match all conditions, but is willing and the right gender if applicable add to threeStar list
                    //person is unavailable because of potential calling conflict or already scheduled. 
                    $this->subListSorted[3][] = $sub;
                } else if($sub->willing($willing) || ($sub->gender == $gender && !$this->music)) {
                    //if sub is willing or the right gender add to the twoStart list
                        $this->subListSorted[2][] = $sub;
                    } else { 
                    //else if the don't match the criteria add to oneStar list
                    $this->subListSorted[1][] = $sub;
                 }
            }
            //return subListSorted with sub lists populated
            return $this->subListSorted;
            
        }

        public function submitScheduleSub($sub) {
            //add a date to a sub when they have agreed to sub for someone. 
            
            //set the cell for the selected sub's sub dates
            $range = "{$this->sheetName}!{$this->lastSubbedColumn}{$sub->row}";
            //convert array of dates to a string
            $dates = implode(', ', $sub->lastSubbed);
            //create a ValueRange and populate it with the string of dates
            $values = new Google_Service_Sheets_ValueRange(array(
                'values' => [
                    [$dates]
                ]
            ));
            
            //update the sheet's sub dates cells for the given sub to include the date they agreed to sub                
            $this->service->spreadsheets_values->update($this->spreadsheetID, $range, $values, array("valueInputOption"=>"RAW"));
        }
    }

?>

