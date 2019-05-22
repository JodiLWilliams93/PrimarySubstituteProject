<?php 

    require_once '../admin/header.php';
  
    loggedIn('confirm'); //check if user is logged in.
    
    $sheet = PrimarySubSheet::getInstance([]); //get sheet object to interact with google sheet

    if($_SERVER['REQUEST_METHOD'] === 'GET') {
        //get row, date, and type if set 
        $row = $_GET['row'] ?? '';
        $date = $_GET['date'] ?? '';
        $type = $_GET['type'] ?? '';
        //find sub from sheet using row
        $sub = $sheet->findSubByRow($row);
        //add date to sub's lastSubbed array
        $sub->scheduleSub($date);
        //update sub on google sheet to include new subdate
        $sheet->submitScheduleSub($sub);
        //format date to a more readable view
        $dateFormatted = date('F j, Y', strtotime($date));

            
    }

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirm Schedule Substitute</title>
</head>
<body>

   <div class="content above-center">
       <p>You scheduled <?php echo $sub->name; ?> to <?php echo $type; ?> on <?php echo $dateFormatted; ?>.</p>
    
       <a href="index.php">Return to home page</a>
        
   </div>
<?php require_once '../admin/footer.php'; ?>
