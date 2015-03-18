<?php
    session_start(); //start a session
    require_once("mysql_connect.php"); //connect to our mysql database
    
    //get username and password values from our login form, and put them in easier-to-use variables
    $username = $_POST['username']; //$username = ?
    $password = $_POST['password'];//$password = ?

    //convert our password into a hashed password, using the function "sha1": $password
    $password = sha1($password);

    $query = "SELECT * FROM users WHERE password='$password' AND username='$username'";//construct an SQL statement, $query, that selects the record with both our username and hashed password, $username and $password. The table is "users" 
    $results = mysqli_query($CONN, $query); //execute $query, and receive the results in $results
    if(mysqli_num_rows($results) === 1){    //if a row was returned, the user is validated.  
        while($row = mysqli_fetch_assoc($results)){
            $user_info = ['fname' => $row['firstName'], 
                          'lname' => $row['lastName'],
                          'color' => $row['favColor']]; //if the user was validated, fetch the user's data into $user_info variable
        }
        $_SESSION['userinfo'] = $user_info;         //put the user's data into a key/value pair in the session superglobal.  Use key 'userinfo' in the session superglobal
        echo "<h1>Welcome back $user_info[fname] $user_info[lname]!</h1>";   
    }else{                                           //else the user wasn't validated
        echo "<h1>Invalid username or password</h1>";                                            //inform the user that their username/password was incorrect
    }//end of file.  output any results here.
?>
