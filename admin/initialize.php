<?php 
    ob_start(); //turn on output buffering    

    //set constant's for file paths
    define("ADMIN", dirname(__FILE__));
	define("PROJECT", dirname(ADMIN));
	define("PUBLIC", PROJECT . '/public');

    //autoload functions
    function my_autoload($class) {
        //load vendor/autoload
        require_once ADMIN . '/vendor/autoload.php';
        
        //find user classes
        if(preg_match('/\A\w+\Z/', $class)){
            include ADMIN . '\classes/' . $class . '.class.php';
        }
    }
    
    //autoload classes using my_autoload function
    spl_autoload_register('my_autoload');
    
    //include functions
    require_once 'functions.php';

    //create sheet object include the spreadsheetID, sheetName, and keys-column names
    $sheet = createSheet(array(
        'spreadsheetID' => '1IeYRgbUF6GuWo8B7oXDa1wEYiSjzkrP6iZOLeaj0YiY',
        'sheetName' => 'Master',
        'keys' => ['timestamp', 'name', 'gender', 'oddSundays', 'evenSundays', 'willing', 'contact', 'phone', 'email', 'lastSubbed']
    ));


?>