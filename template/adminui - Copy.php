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





$html = "







<div name='$status'  class='hiddendiv'>



            <form class='adminform'>



                ";



                if($status != "info"){



                    $html .="



                        <div id='".$status."subject' style='display:none; width:100%; padding:0px; margin:0px'>



                            <input type='text' class='input-search form-control pull-left' value='".$subject."'  style='width:90%; height:1.5em; font-size:1.5em; ' name='custom".$status."select' placeholder='Alert Subject'>

                            <div  class='subject btn btn-danger pull-right '><i class='glyphicon glyphicon-remove'></i></div>

                                



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



                    <div style='width:100%; height:20%;'>



                        <div class='btn-group' data-toggle='buttons-checkbox' style='margin: 1%; padding:3px; height:45px; width:44.5%'>



                          <button type='button' class='btn btn-primary'>E-Mail</button>



                          <button type='button' class='btn btn-primary'>Text</button>



                          <button type='button' class='btn btn-primary'>Twitter</button>



                        </div>



                        <input type='submit' class='btn btn-primary ' style='margin: 1%;padding:3px; height:45px; width:44.5%; font-weight:bold;' value='Send Alert'>



                        <input type='hidden' name='status' value='$status'>



                        



                    </div>



            </form>



                



        </div>



        </div>



    







        ";



return $html;



        ?>