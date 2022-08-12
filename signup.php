<?php

session_start(); 

    include 'connection.php';
   
    
    
    $newfname =$_POST['fname'];
    $newlname =$_POST['lname'];
    $newid =$_POST['idnum'];
    $newphone =$_POST['phone'];
    $newaccount =$_POST['account'];
    $newaddress =$_POST['address'];
    $newage =$_POST['age'];
    $newpasswords =$_POST['passwords'];
    $newemail =$_POST['email'];

 

    
    //Query for checking if such user with the registered ID exists 
    $sql = "SELECT * FROM users WHERE idnum = '$newid'"; 
    $result = sqlsrv_query( $conn , $sql, array(), array("Scrollable" => 'static'));
    $my_array = sqlsrv_fetch_array($result); 
    
    
    // If another user with same ID has been found
    if(sqlsrv_num_rows($result) > 0){
        
            header("Location: notsucsesspage.html");
            
            

    }
    else { 

        
        $sql2 = "INSERT INTO users (fname,lname,idnum,phone,usertype,city,age,passwords,email)
        VALUES ('$newfname','$newlname','$newid','$newphone','$newaccount','$newaddress','$newage','$newpasswords','$newemail')";
        $params2 = array( $newfname,$newlname,$newid,$newphone,$newaccount,$newaddress,$newage,$newpasswords,$newemail); 
        $options2 =  array('Scrollable' => SQLSRV_CURSOR_FORWARD);
        $result2 = sqlsrv_query( $conn , $sql2, $params2);	
        
      

    }   

        
         if( $sql && $sql2  ) {
            sqlsrv_commit( $conn );
            header('Location: sucsesspage.html');
            
        }


    else { 
				
        // If something went wrong
        sqlsrv_rollback( $conn );		
    }
?>