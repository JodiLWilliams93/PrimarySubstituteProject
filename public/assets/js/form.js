$(document).ready(function() {
    
    //check the input to see if it has a value or not.
    function isBlank(field) {
        var value = $(field).val();
        if(value) {
            return false;
        } else {
            return true;
        }
        
    }; //end isBlank
    
    //checks to see if the given date is after today's date
    function isFuture(date) {
        var today = new Date(); //get today's date
        if(today > date) { 
            //if before today, display error message.
            $("#date-field").children(".future-error").show();
        } else {
            //if after today, make sure error message is hidden.
            $("#date-field").children(".future-error").hide();
        }
    }; //end isFuture

     $("select").change(function(){
        //get the option that is selected
        var selectedSub = $(this).children("option:selected").val();
        //see if option is a music calling
        if(selectedSub == "Lead the music" || selectedSub == "Play the piano") {
            $("#gender").hide(); //if a music calling hide gender selections
        } else {
            $("#gender").show(); //if not a music calling show gender selections
        }
    }); //end select.change

    $("#date").change(function(){
        var value = $(this).val();
        var regex = new RegExp('[0-9]{4}-[0-9]{2}-[0-9]{2}'); //regex for date from browsers supporting date type
        var regex1 = new RegExp('([0-9]{1,2}/){2}[0-9]{4}'); //regex for date from browsers treating date as text
        if (isBlank('#date')) {// make sure date has a value
            $("#date-field").children(".blank-error").show(); 
        }
        if (regex.test(value)) { //create date using appropriate pieces from regex
            var parts = value.split('-');
            var date = new Date(parts[0], parts[1]-1, parts[2]);
            $("#date-field").children(".format-error").hide();
        } else if (regex1.test(value)) {
            var parts = value.split('/');
            var date = new Date(parts[2], parts[0]-1, parts[1]);
            $("#date-field").children(".format-error").hide();
        }else { //date doesn't match regex expression, display format error message
            $("#date-field").children(".format-error").show(); 

        }
        isFuture(date); //make sure the date is in the future
        if(date.getDay() != 0) {
            //show Sunday error message if the date is not a Sunday
            $("#date-field").children(".sunday-error").show();
        } else {
            //hide Must be Sunday error message if date is a Sunday
            $("#date-field").children(".sunday-error").hide();
        }
        //hide blank error message because a date has been selected.
        $("#date-field").children(".blank-error").hide();
    }); //end #date.change


    $("#type").change(function(){
        if(!isBlank("#type")) {
            //hide the blank error if a type has been selected- type isn't blank.
            $("#type-field").children(".error").hide();
        }
    });
    
    //checks validations before submitting form
    $("form").submit(function(e) {
        //check if #type is blank and shows error if is blank.
        if(isBlank("#type")) {
            $("#type-field").children(".error").show();
        }
        
        //check if #date is blank and shows error if is blank.
        if(isBlank("#date")) {
            $("#date-field").children(".blank-error").show();
        }
        
        //if any errors are visible, prevent form from submitting. 
        if($('.error').is(":visible")){
            e.preventDefault();
        }
    });

});