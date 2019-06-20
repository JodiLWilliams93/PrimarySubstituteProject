<?php 
    require_once '../admin/header.php';

    $page = 'display';

    loggedIn($page); //check if loggedIn
    
    //set gender and type
    $gender = $_POST['gender'] ?? '';
    $type = $_POST['type'] ?? '';
    
    //get the date submitted
    $submitted = date('Y-m-d', strtotime($_POST['date']));
    //get today's date
    $today = date('Y-m-d', time());
    //get next Sunday's date
    $nextSunday = date('l, dS F',strtotime('next Sunday'));
    //if the submitted date is before today use the date as next Sunday
    $date = ($submitted > $today) ? $submitted : $nextSunday;
    //make the date more readable for the user
    $dateFormatted = date('F j, Y', strtotime($date));

    //get all the subs from the sheet
    $sheet->createSubList();
    
    //sort subs according to how well they match criteria
    $subList = $sheet->filterSubsBy($gender, $date, $type);
    
    ?>
   
   <div id="sub-list" class="content flex-center">
       
       <!-- ******************* show matching substitutes *******************-->
       
       <div class="heading flex-center">
           <h2><span class="heading-title">Substitutes matching: </span> <br> 
           <?php   
                if($sheet->music) {
                    //if its a music calling don't display gender
                    echo "{$dateFormatted}, {$type}.";
                } else {
                    //show gender if not a music calling
                    echo "{$dateFormatted}, {$gender}, {$type}."; 
                }
            ?>
            </h2>
        </div><!-- end heading.flex-center-->

        <div id="matching">         
            <?php 
                for($i=5; $i >= 3; $i--){
                    //shuffle and show the 5,4, and 3 star matches.
                    shuffle($subList[$i]);
            
                    foreach($subList[$i] as $sub){ //show each sub in those lists
                        include 'details.php';
                    }
                }
            ?>
        </div><!-- end #matching -->

    <!-- ******************* show nonmatching substitutes *******************-->
    
        <div id="nonmatching" class="show">
            <h3 class="center-text">The following subs do not strongly match your search criteria, but may still be able to substitute for you.</h3>
            <div class="buttons">
                <button id="hide-additional">Hide Additional Subs</button>
            </div>
            
           <?php 
                //shuffle and show the 2 and 1 star matches
                for($i=2; $i > 0; $i--){
                    shuffle($subList[$i]);
                    foreach($subList[$i] as $sub){ //show each sub in those lists
                        include 'details.php';
                    }
                }
            ?>
        </div><!-- end #nonmatching.show-->
                
    <!-- ******************* buttons and links *******************-->
    <div class="flex-sb flex-wrap buttons">
        <button id="show-nonmatching">Show Additional Subs</button>
        <a class="reset" href="index.php">Reset Search</a>
    </div><!-- end .flex-center.buttons -->

<!--******************* modal *******************-->
    <!-- Modal is populated with information from substitute when the schedule sub button is clicked. The message is created in /public/assets/js/main.js -->

    <div id="openModal" class="modalDialog"> 
        <div class="inner">
            <a href="#close" title="Close" class="close">X</a>
            <div id="schedule-message"></div>
        </div><!-- end close -->
    </div> <!-- end openModal-->

<!--******************* Legend *******************-->
    <div id="legend" class="modalDialog">
        <div class="inner">
            <a href="#close" title="Close" class="close">X</a>
            <p><span class="rating5 h2"><?php echo str_repeat("&#9733;", 5); ?></span>: Substitute is willing to cover the selected position, is the correct gender, does not have a calling, and has not subbed in the past 6 weeks.</p>
            <p><span class="rating4 h2"><?php echo str_repeat("&#9733;", 4); ?></span>: Substitute is willing to cover the selected position, is the correct gender, does not have a calling, and has not subbed in the past 4 weeks.</p>
            <p><span class="rating3 h2"><?php echo str_repeat("&#9733;", 3); ?></span>: Substitute is willing to cover the selected position and is the correct gender, but has subbed in the past 4 weeks or may have a calling.</p>
            <p><span class="rating2 h2"><?php echo str_repeat("&#9733;", 2); ?></span>: Substitute is willing to cover the selected position or is the correct gender.</p>
            <p><span class="rating1 h2"><?php echo str_repeat("&#9733;", 1); ?></span>: Substitute does not match any of the specified criteria.</p>
        </div><!-- end close -->
    </div> <!-- end legend -->

    <div>
        <p>If you are unable to schedule a substitute, please contact Primary President.</p>
    </div>
</div><!-- end .flex-center.content-->
<?php require_once '../admin/footer.php'; ?>
    