<!DOCTYPE html>
<html>
    <head>
        <title> Sign Up Page </title>
        <link href="styles.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    </head>
    <body>
        <h1> Sign Up</h1><br>
        
        <form id="signupForm" action="welcome.html">
        
            First Name:     <input type="text"    name="fname"><br><br>
            Last Name:      <input type="text"    name="lName"><br><br>
            Gender:         <input type="radio"   name="gender"     value="m"> Male 
                            <input type="radio"   name="gender"     value="f"> Female <br><br>
                        
            Zip Code:       <input type="text"    id="zip"    name="zip"><br><br>
            City:           <span id="city"></span><br><br>
            Latitude:       <span id="latitude"></span><br>
            Longitude:      <span id="longitude"></span><br><br>
        
            State:
            <select id="state" name="state">
                <option> Select One </option>
                <option value="ca"> California   </option>
                <option value="ny"> New York     </option>
                <option value="tx"> Texas        </option>
            </select><br><br>
        
            Select a County: <select id="county"></select><br><br>
        
            Desired Username: <input type="text" id="username"><br>
                              <span id="usernameError"></span><br>
        
            Password:         <input type="password" id="password" name="password"><br>
                              <span id="passwordError"></span> <br>
            Password Again:   <input type="password" id="passwordAgain"><br>
                              <span id="passwordAgainError"></span> <br><br>
        
            <input id="submitBtn" type="submit" value="Sign Up!">
        
        </form>
        
        <script>
            
            var usernameAvailable = false;
            
            //Displaying City from API after typing a zip code
            $("#zip").on("change", async function(){
                
                //alert($("#zip").val());
                let zipCode = $("#zip").val();
                let url = `https://itcdland.csumb.edu/~milara/ajax/cityInfoByZip.php?zip=${zipCode}`;
                let response = await fetch(url);
                let data = await response.json();
                //console.log(data)
                $("#city").html(data.city);
                $("#latitude").html(data.latitude);
                $("#longitude").html(data.longitude);
                

            });//zip
            
            $("#state").on("change", async function(){
                
                //alert($("#state").val());
                let state = $("#state").val();
                let url = `https://itcdland.csumb.edu/~milara/ajax/countyList.php?state=${state}`;
                let response = await fetch(url);
                let data = await response.json();
                //console.log(data)
                $("#county").html("<option> Select one </option>");
                for (let i=0; i < data.length; i++) {
                    $("#county").append(`<option> ${data[i].county} </option>`);
                }
                
            });//state
            
            $("#username").on("change", async function(){
                
                //alert($("#username").val());
                let username = $("#username").val();
                let url = `https://cst336.herokuapp.com/projects/api/usernamesAPI.php?username=${username}`;
                let response = await fetch(url);
                let data = await response.json();
                
                if (data.available) {
                    $("#usernameError").html("Username available!");
                    $("#usernameError").css("color", "green");
                    usernameAvailable = true;
                } else {
                    $("#usernameError").html("Username not available!");
                    $("#usernameError").css("color", "red");
                    usernameAvailable = false;
                }
                
            });//username
            
            $("#signupForm").on("submit", function(e){
                
               // alert("Submitting form...");
               if (!isFormValid()){
                   e.preventDefault();
               }
                
            });
            
            function isFormValid(){
                isValid = true;
                if (!usernameAvailable){
                    isValid = false;
                }
                
                if($("#username").val().length == 0){
                    isValid = false;
                    $("#usernameError").html("Username is required");
                    $("#usernameError").css("color", "red");
                }
                
                if ($("#password").val() != $("#passwordAgain").val()){
                    $("#passwordAgainError").html("Password Mismatch");
                    $("#passwordAgainError").css("color", "red");
                    isValid = false;
                } else {
                    $("#passwordAgainError").html("");
                }
                
                if($("#password").val().length < 6){
                    isValid = false;
                    $("#passwordError").html("Password must be at least 6 characters.");
                    $("#passwordError").css("color", "red");
                } else {
                    $("#passwordError").html("");
                }
                
                return isValid;
            }
            
        </script>
        
        <br><br>
        
        <footer>
            <hr>
            
            <div id="footersection">
            
            <figure>
                <img src="img/csumb_round_logo.png" alt="CSUMB Logo" />
            </figure>
            
            <div>
            CST336 Internet Programming. 2020&copy; Zauderer
            <br/>
            <strong>Disclaimer:</strong> The information in this webpage is fictitious.
            <br/>
            It is used for academic purposes only.
            </div>
            
            </div>
        </footer>
        
    </body>
</html>