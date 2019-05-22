<?php 

    class Substitute {
        //number corresponding to the row in the spreadsheet
        public $row;
        //string name of the substitute
        public $name;
        //boolean for having a calling on odd Sundays
        public $oddSundays;
        //boolean for having a calling on even Sundays
        public $evenSundays;
        //string of positions willing to cover, comma separated
        public $willing;
        //preferred method of contact: Text, Call, Email (data from previous forms may included call or text or a phone placeholder)
        public $contact = '';
        //string with phone number
        public $phone = '';
        //string email addresss
        public $email = '';
        //string Male or Female
        public $gender = '';
        //array of dates a sub has subbed or is scheduled to sub
        public $lastSubbed = '';
        //integer with the least amount of weeks between datess subbed and the date someone is looking for a sub. if there are no sub dates it will revert to 52 weeks or a year from the last time the sub was used. 
        public $timeFromSub = 52;

        public function __construct(array $args) {
            //create object properties for each item in the args array
            foreach($args as $key => $value) {
                //if a field was blank, assign it an empty string
                $this->$key = $value ?? '';
                if($key = 'lastSubbed') {
                    //if the field is lastSubbed and there is a value, split the string into individual dates and make an array. 
                    if($value != '') {
                        $this->lastSubbed = explode(', ', $value);
                    } else {
                        //if no value in lastSubbed set it to an empty array
                        $this->lastSubbed = array();

                    }
                }
            }
        }

        public function __toString()
        {
            //print the row, name, phone, email, and dates subbed
            return $this->row . ": " . $this->name . " " . $this->phone . " " . $this->email . " " . implode(', ', $this->lastSubbed);
        }

        public function available($date) {
            //check if the sub has a calling on the selected date
            $hasCalling = $this->checkCalling($date);
            //if person has a calling they are unavailable return false
            if($hasCalling) {
                return false;
            }
            //if the person doesn't have a calling, they are available, return true
            return true;
        }
        
        public function timeFromSub($dateSelected) {
            
            //check if lastSubbed has a value if it does loop through each date
            if(!empty($this->lastSubbed)) {
                foreach($this->lastSubbed as $subDate) {
                    //initialize 3 dates, the selected date for someone to sub, the date subbed, and today's date
                    $date1 = new DateTime($subDate);
                    $date2 = new DateTime($dateSelected);
                    //find the difference in days between the date selected and date subbed returns an absolute difference
                    $interval = $date1->diff($date2, true);
                    //figure out how many weeks there are between the selected and subbed dates
                    $weeks = floor($interval->days/7);
                    //if the number of weeks is less than timeFromSub, set timeToSub to weeks.
                    if($weeks < $this->timeFromSub) {
                        $this->timeFromSub = $weeks;
                    }

                }
            }
            
        }

        public function willing($class) {
            //check if the selected class is in the sub's willing string
            return strpos($this->willing, $class) !== false;
            
        }

        public function scheduleSub($date) {
            //add date to lastSubbed to schedule the sub
            $this->lastSubbed[] = $date;
        }

        public function findWeek($date) {
            //find the number day of the week
            $day = date('d', strtotime($date));
            //find if date is the first, second...Sunday of the month
            return ceil($day / 7);
        }

        public function checkCalling($date) {
            //figure out if a week is an even or odd week
            $week = $this->findWeek($date) % 2;
            //figure out if the sub has a calling on the odd Sunday and if this is an odd Sunday
            $odd = ($this->oddSundays == 'No') && $week;
            //figure out if the sub has a calling on the even Sunday and if this is an even Sunday
            $even = ($this->evenSundays == 'No') && !$week;            
            
            //if it is a 5th Sunday or the person is free (doesn't have a calling on the even or odd sunday) return false: doesn't have a calling on the date selected
            if($this->findWeek($date) == 5 || $odd || $even) {
                return false;
            } 
            //if has a calling return true
            return true;
        }

        public function formatDates(string $format = 'Y-m-d') {
            //make all lastSubbed dates in the same format
            foreach($this->lastSubbed as $date) {
                //for all dates convert to the specified format
                $dates[] = date($format, strtotime($date));
            }
            //set the lastSubbed to $dates array with formatted dates
            $this->lastSubbed = $dates;        
        }
        
    }
    
?>