<?php
    session_start();
    $everything_is_ok = true;
    if(isset($_SESSION['alert'])){
            $id = $_SESSION['alert']['id'];
            unset($_SESSION['alert']);
    }
    $msg = "";

    
    if($_POST["custom".$_POST['status']."select"])
        {
            $subject = $_POST["custom".$_POST['status']."select"];
        } else{
            $subject = $_POST[$_POST['status']."select"];
        }

    if(!$_POST['dmethod'] ){

        $msg .= "Please select at least one delivery method (Email, Text, Twitter)<br>";
        $everything_is_ok = false;
    }
    if(!$_POST['status']){

        $msg .= "You broke this in such a way that I can not possibly explain. Congrats.<br>";
        $everything_is_ok = false;
    }
    if(!$_POST['msg']){

        $msg .= "Please enter a message.<br>";
        $everything_is_ok = false;
    }elseif(strlen($_POST['msg']) > 255){
        $msg .= "Your message is too long! Character limit is 255, you entered " . strlen($_POST['msg']);
        $everything_is_ok = false;
    }
    if(!$subject || $subject == "Select A Default Message<br>"){

        $msg .= "Select or enter a subject.<br>"; 
        $everything_is_ok = false;
    }elseif(strlen($subject) > 50){

        $msg .="Your subject is too long! Character limit is 255, you entered " . strlen($_POST['subject']) . "<br>";
        $everything_is_ok = false;
    }
    if(!$_POST[$_POST['status']]){

        $msg .= "You did not select any groups to recieve the notification! <br>";
        $everything_is_ok = false;
    }

        if ($everything_is_ok)
        {

            //Create placeholder in database for alert if we haven't already done so

           if(!$id){

                include("../functions.php");
                dbconnect();


                $query = mysql_query("INSERT INTO `alerts` (`subject`) VALUES ('placeholder')");
                if($query){
                    $getID = mysql_query("SELECT `id` FROM `alerts` WHERE `subject`='placeholder' ORDER BY `id` DESC LIMIT 1") ;
                    $id = mysql_fetch_row($getID) or die(mysql_error());
                    $id = array_pop($id);
                }

           }

            $method = array();
            $method[] = $_POST['dmethod'];

            $_SESSION['alert'] = array(  

                "status" => $_POST['status'],
                "message" => $_POST['msg'],
                "subject" => $subject,
                "services" => $_POST[$_POST['status']],
                "method" => $method,
                "id" => $id,

            );

            echo "<script>window.location='admin.php?a=preview'</script>";

        }
         else 
        {

            echo $msg;
        }

    

?> 