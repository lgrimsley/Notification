<?php



if(isset($_SESSION['alert']['message']) && $_SESSION['alert']['status'] == $status){

    $thistext = $_SESSION['alert']['message'];

} else $thistext = "";

if(isset($_SESSION['alert']['subject']) && $_SESSION['alert']['status'] == $status){

    $subject = $_SESSION['alert']['subject'];

} else $subject = "";

if($status == "up") $label = "success";
elseif($status == "down") $label = "danger";
else $label = "info";

$twitterstyle = array("btn-default", "");
$emailstyle = array("btn-warning active", "checked");
$textstyle = array("btn-warning active", "checked");

if(isset($_SESSION['alert']['method'][0])){

    if(in_array("Twitter",$_SESSION['alert']['method'][0])) $twitterstyle = array("btn-warning active", "checked");
    if(!in_array("Email",$_SESSION['alert']['method'][0])) $emailstyle = array("btn-default", "");
    if(!in_array("Text",$_SESSION['alert']['method'][0])) $textstyle = array("btn-default", "");
}


$html = "



<div name='$status'  class='hiddendiv'>

            <form class='adminform'>
 
                ";

                if($status != "info"){

                    $html .="

                        <div id='".$status."subject' style='display:none; width:100%; padding:0px; margin:0px'>

                            
                            <input type='text' class='input-search form-control pull-left' value='".$subject."'  style='width:88%; ' name='custom".$status."select' placeholder='Alert Subject'>
                          

                            <button type='button'  class='subject btn btn-danger pull-right ' value='$status'><i class='glyphicon glyphicon-remove'></i></button>
                                

                        </div> 

                        <select class='btn btn-$label' style=' font-size:1.2em; width:98% !important; ' id='".$status."select'  name='".$status."select'>

                        <option value='' id=''>Select A Default Message</option>

                        ";

                            

                                if($default != null){

                                    foreach ($default as $u){

                                         if($subject && $_SESSION['alert']['status'] == $status){

                                             if($subject == $u['title']) $selected = "selected";

                                         } else $selected = "";

                                        $html .= "<option id='".$u['text']."' $selected>".$u['title']."</option>";

                                    }

                                }

                                 
 
                                

                                    $html .="<option  value='' id='Custom Message' name='custom'>Custom Message</option>

                            

                                            </select>";

                } else $html .= "<input type='text' class='form-control' value='".$subject."' style='width:100% !important;' name='".$status."select' placeholder='Email Subject'>";







$html .="

                        <textarea name='msg' class='textarea form-control' rows='6'  id='".$status."text' >".$thistext."</textarea>

                    

                    <div style='min-width:280px; max-width:600px; width:100%;'>";                        

                        $html .= showSubscription("admin","",$status);


$html .="           </div>

                    <div style='width:100%; height:20%; '>
                        <div class='vmiddle' style='width:48%; height:20%;text-align:center;'>
                            <div class='btn-group vmiddle' style='width:100%; '  data-toggle='buttons'>
                              <label class='btn ".$emailstyle[0]." msgcheck' id='".$status."emailb'  style='width:30%'>
                                <input type='checkbox' ".$emailstyle[1]." name='dmethod[]' value='Email' id='".$status."email' > <i class='glyphicon glyphicon-envelope'></i>
                              </label>
                              <label class='btn ".$textstyle[0]." msgcheck' id='".$status."txtb'  style='width:30%'>
                                <input type='checkbox' ".$textstyle[1]."  name='dmethod[]' value='Text' id='".$status."txt' > <i class='glyphicon glyphicon-phone'></i>
                              </label>
                              <label class='btn ".$twitterstyle[0]." msgcheck' id='".$status."twtrb'  style='width:30%'>
                                <input type='checkbox' name='dmethod[]' ".$twitterstyle[1]." value='Twitter' id='".$status."twtr' class=''> <img src='twtr.png' style='height:18px; width:18px;'>
                              </label>
                            </div>
                        </div>
                        <div class=' vmiddle' style=' width:48%; height:20%;'>

                        <button type='submit' class='btn btn-primary ' style='margin: 1%;padding:3px; height:45px; width:85%; font-weight:bold;'>
                            Preview Alert <i class='glyphicon glyphicon-arrow-right'></i>
                        </button>

                        <input type='hidden' name='status' value='$status'>
                        </div>
                        

                
                    </div>

            </form>

                

        </div>



    



        ";

return $html;

        ?>