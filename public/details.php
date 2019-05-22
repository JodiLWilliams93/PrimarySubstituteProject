<?php 
    if(!isset($_COOKIE['loggedIn'])) {
        //if the user is not logged in redirect to login
        header('Location: login.php');
    }
?>
<!-- ****************** Basic Information *****************-->
<div class="substitute-card flex-center">
    <div class="basic-info flex-center flex-wrap">

    <!--****************** image and rating ****************** -->
        <div class="image">
            <div class="flex-center image-container">
                <img class="" src="assets/img/<?php echo $sub->gender; ?>.png" alt="">
            </div><!-- end .flex-center .image-container -->
            <?php echo "<a href='#legend' class='rating{$i} ratings modalLink'>" . str_repeat("&#9733;", $i) . "</a>"; ?>
        </div><!-- end .information -->
        
        <!--****************** name ******************-->
        <div class="not-image">
            <div class="information name">
                <div class="flex-fs">
                    <h4 class="inline-block"><?php echo $sub->name; ?></h4>
                </div><!--end .flex-fs -->
            </div><!-- end .information -->
            
            <!--****************** contact ****************** -->
            <div class="information contact">
                <p class="flex-fs">
                    <?php 
                    if($sub->contact == "Email") { 
                        //if the preferred contact method is email use that as the primary contact and set secondary contact as phone with number
                        $primaryContact = $sub->email; 
                        $secondaryContact = array("Phone", $sub->phone);
                    } else {
                        if(!$sub->contact) {
                            //if no contact method was found use 'Phone' as the preferred contact
                            $sub->contact = 'Phone';
                        }
                        //if the contact method isn't email use the phone as primary contact and email as the secondary
                        $primaryContact = $sub->phone;
                        $secondaryContact = array("Email", $sub->email);
                    }
                    echo $sub->contact . ": <br>" . $primaryContact; //display the primary contact information
                ?>
                </p><!--end .flex-fs -->
            </div><!-- end .information -->
            
            <!--****************** schedule and show more buttons ******************-->
            <div class="information schedule-buttons">
                <div class="flex-fs">
                    <a href="#openModal" class="schedule modalLink" 
                    data-row="<?php echo htmlspecialchars($sub->row); ?>"
                    data-name="<?php echo htmlspecialchars($sub->name); ?>"
                    data-type="<?php echo htmlspecialchars($type); ?>"
                    data-format="<?php echo htmlspecialchars($dateFormatted); ?>"
                    data-date="<?php echo htmlspecialchars($date); ?>"
                    >Schedule Sub</a>
                    <button class="show-additional" data-row="<?php echo $sub->row; ?>">+</button>
                </div><!--end .flex-fs -->
            </div><!-- end  .information -->
        </div>
    </div><!-- end .basic-info -->
</div><!--end .substitute-card .flex-center -->

<!-- ****************** Additional Information *****************-->
<div class="flex-center substitute-card">
    <div class="extra-info show" data-row="<?php echo $sub->row; ?>">
        <?php 
            //format dates so they are all the same
            $formattedDates = formatDates($sub->lastSubbed);
            //make all dates into a single string to display
            $dates = implode(', ', $formattedDates);

            if($dates == '01/01/1970') { //make sure that if no dates are in lastSubbed that nothing is printed
                $dates = '';
            }

            //print out additional information 
            echo "<p class=''><span class='bold'>{$secondaryContact[0]}: </span>{$secondaryContact[1]} </p>";
            echo "<p class=''><span class='bold'>Gender: </span>{$sub->gender}</p>";
            echo "<p class=''><span class='bold'>First and third Sunday calling: </span> {$sub->oddSundays}</p>";
            echo "<p class=''><span class='bold'>Second and fourth Sunday calling: </span> {$sub->evenSundays}</p>";
            echo "<p><span class='bold'> Recent and upcoming sub dates: </span> {$dates} </p>";
            echo "<p><span class='bold'>Classes willing to cover: </span>{$sub->willing}</p>";

        ?>
    </div>
</div>
