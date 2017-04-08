<?php include('includes/header.php'); 

$school = new School();    
    //$editMode=false;

        if($_REQUEST["id"] != "") {
        try{
            $rows = $dbo->GetSchool($_REQUEST["id"]);            
            $school->id = $rows[0]['id'];
            $school->school_name = $rows[0]['school_name'];
            $school->school_address1 = $rows[0]['school_address1'];
            $school->school_address2 = $rows[0]['school_address2'];
            $school->school_city = $rows[0]['school_city'];
            $school->school_zip = $rows[0]['school_zip'];
            $school->school_phone = $rows[0]['school_phone'];
            $school->school_county = $rows[0]['school_county'];  

            

        }
       
        catch (Exception$ex){

        }
    }
    if(isset($_POST['addComment'])) 
    {     
    try{
        if(trim($_POST["comments"])!=""){
            $dbo->AddSchoolComment($_REQUEST["id"], $_POST["comments"]);
        }
    }
    catch (Exception $ex){

    }
    }
    
?>
<h4>School Information</h4>
<div id="log" style="width:50%;float:right;top:0;">
        <?php
        $comments = $dbo->GetSchoolComments($_REQUEST["id"]);
        foreach($comments as $comment){
            echo "<div class='logDate'>" .  $comment["date_added"] . "</div><div class='logEntry'>" . $comment["comment"] . "</div>";
        }
        ?>
    </div>
    <div >
    
        <?php 

        $schoolInfo = "<strong>" . $school->school_name . "</strong><br/>" . $school->school_address1;
         if(strlen($school->school_address2)>0)
            $schoolInfo .= "<br/>" . $school->school_address2; 
        $schoolInfo .= "<br/>" . $school->school_city . ", " . $school->school_state . " " . $school->school_zip . "<br/>" . $school->school_county . "<br/>" . $school->school_phone . "<br/>"; 
        echo $schoolInfo;
        ?>
    </div>
    
    <div style="width:45%;">
    <form style="display:block;" class="form-horizontal smileForm" id="SmileForm" name="SmileForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
        <fieldset>
            
            <div>
                <div class="form-group">
                    <label class="control-label col-lg-10" for="comments">Comment</label>
                    <div class="col-lg-10">
                        <textarea class="form-control" name="comments" id="comments" rows="10"></textarea>
                    </div>
            </div>
            <div class="form-group" style="display:block;">
                <div class="col-lg-10 col-lg-offset-2">
                  <input type="submit" value="submit" id="addComment" name="addComment">
                </div>
            </div>
        </fieldset>
        <input type="hidden" id="id" name="id" value="<?php echo isset($school->id) ? $school->id : ''; ?>">
    </form>
    </div>
<?php include('includes/footer.php');?>