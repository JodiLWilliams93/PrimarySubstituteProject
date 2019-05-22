# PrimarySubstituteProject
Code for website to randomize and sort substitute for a primary from a GoogleSheet
<h2>Setting Up the project:</h2>

<ul>
  <li>Set up an account on Google Cloud Platform.</li>
  <li>Create Google Form and navigate to the spreadsheet that is associated with the form repsonses</li>
  <ul>
    <li><a href="https://docs.google.com/document/d/1swE-nNIVFJJxvhZqhFumh00oQxZoLkOiMkI3MrlUEFc/edit" target="_blank">View sample form</a></li>
  </ul>
  <li>On Google Cloud Console, create a new project</li>
  <ul>
    <li> Click on the dropdown menu to the right of the Google Cloud Platform brand on the top left</li>
    <li>Click on "New project"</li>
    <li>Name your project</li>
    <li>Click "Create" to create the project</li>
    <li>Select project from the dropdown menu at the top of the page after it is created</li>
  </ul>
  <li>Create a service account to authenticate interaction with the Google Sheets</li>
  <ul>
    <li>Open the navigation menu on the left side of the screen and select "Service Accounts"</li>
    <li>Click "+ Create Service Account" to create an account</li>
    <li>In step 3, create a key and download it in json format</li>
    <li>Rename the downloaded file "credentials.json" and place in the admin/authentication</li>
    <li>Copy the email address from credentials.json and give edit permissions to the Google Sheet to that email</li>
   </ul>
   <li>Update spreadsheet information in /admin/initialize.php</li>
   <ul>
    <li>SpreadsheetId can be found in the url for the google sheet between https://docs.google.com/spreadsheets/d/<strong>spreadsheet id is here</strong>/edit....</li>
    <li>Sheet Name is found on the tab at the bottom of the spreadsheet</li>
    <li>Keys are shortened names to represent each column. They are used to create substitute objects with that information as properties under the key names. Note: changing the keys will require updating the substitute class properties to reflect the new keys.</li>
   </ul>
  <li>Install Composer and required packages in the composer.json file. </li>
  <li>Customize information in admin/classes/PrimarySubSheet.class.php<li>
    <ul>
      <li>Change the letter representing the column with the list of dates the substitute most recently subbed if not "J"</li>
      <li>Change callings where gender is not checked in the array $ignoreGender</li>
      <li>Modify criteria by which to sort and rank substitute matching in method filterSubsBy(), criteria are time from last subdate, gender, willingness, and availability based on other callings. </li>
        <ul> 
          <li>If criteria is modified, update the description of criteria  used in the modal with id=legend in /public/display.php</li>
        </ul>
    </ul>
  <li>Customize form checking and error messages in /public/assets/js/form.js</li>
  <li>Password information can be found on /public/login.php</li>
  
    
