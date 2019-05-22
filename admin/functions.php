<?php 

/**
 * array $info include at least the following information:
 * string spreadsheetID,
 * string sheetName, 
 * array keys: column identifiers that will become characterstics for subs
 */
function createSheet(array $info) {
    //create sheet object that can be used to interact with the google sheet 
    $sheet = PrimarySubSheet::getInstance($info);
    return $sheet;
}

function loggedIn($page) {
    //check if the person has logged in with in the last hour.
    if(isset($_COOKIE['loggedIn'])) { return true; }
    
    //if the page is the login and not logged in return false to avoid redirect loop
    if($page == 'login') {
        return false;
    } else {
        //if not logged in and not login page redirect to the login page
        $url = '../public/login.php';
        header('Location: '. $url);
        exit;
    }
}

function formatDates(array $dates){
    //format dates in mm/dd/YYYY format
    $formatted = []; //create empty array to hold formatted dates
    foreach($dates as $date) {
        //format date and add it to the array of formatted dates
        $formatted[] = date('m/d/Y', strtotime($date));
    }
    //return array with formatted dates
    return $formatted;
}

   
?>