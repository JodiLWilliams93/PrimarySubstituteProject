$(document).ready(function(){
    //TODO: Comment and organize into sections to make navigation easier

    //Show additional information for the sub
    $(".show-additional").click(function(){
        //find the which sub was selected based on the data-row field
        var row = $(this).data("row");
        var text =  $(this).text(); //what the button is currently displaying
        
        //show or hide the additional information using the data-row from the button selected.
        $("div[data-row='" + row + "']").toggleClass("show");

        //replace button text with the appropriate symbol
        if (text === "+") { $(this).text("-"); } 
        else { $(this).text("+"); }

    }); //end .show-additional.click

    //create a message for the modal that appears when clicking "Schedule sub"
    $(".schedule").click(function(){
        //retrieve information from data- fields with link to #openModal in details.php and create message
        var row = $(this).data("row");
        var date = $(this).data("date");
        var format = $(this).data("format");
        var name = $(this).data("name");
        var type = $(this).data("type");
        var message = "Did " + name + " agree to " + type + " for you on " + format + "?";
        var url = "confirm.php?date=" + date + "&row=" + row + "&type=" + type;

        //put message into #schedule-message div in #openModal in display.php
        $("#schedule-message").html("<p>"+message + "</p><div class='flex-se'><a href=" + encodeURI(url) + ">Yes</a><a href='#no' title='No' id='no'>No</a></div>");
    
    }); //end .schedule.click

    //show subs that have 1 or 2 stars when clicking on the "Show Additional Subs button"
    $("#show-nonmatching").click(function(){        
        $("#nonmatching").toggleClass("show");
        //get current text on button
        var text =  $(this).text();
        if (text === "Hide Additional Subs") {
            //when showing top matches change button to display "Show Additional Subs"
            $(this).text("Show Additional Subs");
        } else {
            //when showing all subs change button to display "Hide Additional Subs"
            $(this).text("Hide Additional Subs");
        }

    }); //end #show-nonmatching.click

    //hide additional subs when clicking the top Hide additional subs button
    $("#hide-additional").click(function(){
        $("#nonmatching").toggleClass("show");
        $("#show-nonmatching").text("Show Additional Subs");
    });

   
    //open modal with confirm schedule for sub when clicking on the "Schedule this Sub" link
    $(".schedule").click(function(){
        $("#openModal").show();
        //prevent page from scrolling while modal is open
        var $body = $(document.body);
        var oldWidth = $body.innerWidth();
        $("#openModal").css("display", "flex"); //center modal on the page
        $body.css("overflow", "hidden");
        $body.width(oldWidth);
    });

    //open modal showing explanation of star ratings
    $(".ratings").click(function(){
        $("#legend").show();
        $("#legend").css("display", "flex"); //center modal on the page
        //prevent page from scrolling while modal is open
        var $body = $(document.body);
        var oldWidth = $body.innerWidth();
        $body.css("overflow", "hidden");
        $body.width(oldWidth);
    });
    
    //close #openModal which displays confirmation message if click off modal or if click on the no button
    $('#openModal').click(function (event) {
        if($(event.target).is("#openModal")) {
            $("#openModal").hide();
        } else if($(event.target).is("#no")){
            $("#openModal").hide();    
        }
        //reenable page scrolling after modal is closed
        var $body = $(document.body);
        $body.css("overflow", "scroll");
    });
    
    //close #legend modal if clicking off the modal 
    $('#legend').click(function (event) {
        if($(event.target).is('#legend') ) {
            $("#legend").hide();
            //reenable page scrolling after modal is closed
            var $body = $(document.body);
            $body.css("overflow", "scroll");
        } else {
            
        }
    });
    
    //close modals using the "X"
    $(".close").click(function() {
        $("#openModal").hide();
        $("#legend").hide();
        //reenable page scrolling after modal is closed
        var $body = $(document.body);
        $body.css("overflow", "scroll");
    });

        
    }); //end document.ready

    