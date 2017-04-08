<?php 
    include('includes/header.php');
    $school = new School();    
    //$editMode=false;
    if(isset($_REQUEST['existingSchools']) && !empty($_REQUEST['existingSchools'])){
        try{
            $rows = $dbo->GetSchool($_REQUEST['existingSchools']);            
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
       
    if(isset($_POST['addschool'])) 
    {     
    try{
        if(empty($_POST['schoolName']))
            throw new Exception('School name cannot be blank');
        
        $school->school_name=$_POST['schoolName'];
        $school->school_address1=$_POST['schoolAddress1'];
        $school->school_address2=$_POST['schoolAddress2'];
        $school->school_city = $_POST['schoolCity'];
        $school->school_zip = $_POST['schoolZip'];
        $school->school_county = $_POST['county'];
        $school->school_phone = $_POST['schoolPhone'];
        
  
   
        if(empty($_POST['schoolId'])){
            echo($dbo->AddSchool($school));
            $positiveMessages = "'" . $school->school_name . "' added successfullly.";
        }
        else{
            $school->schoolId=$_POST['schoolId'];          
            $dbo->UpdateSchool($school);
             $positiveMessages = "'" . $school->school_name . "' updated successfullly.";
             header('Location: ' . $_SERVER['HTTP_REFERER']);
        }

        //throw new Exception('this failed miserably');
        
        $_POST = array(); // clear the post data after successfully adding the record.
        unset($school);
        
    }
    catch (Exception $ex){
        if ($ex->getCode() === 1062){//if the record exists lets prompt for an update instead of insert.
            $negativeMessages = "record exists lets to an edit instead.";
        }
        else    
            $negativeMessages = $ex->getMessage();
        //$messages = $ex->getMessage();
    }


    }
    ?>
   
    <div class="well bs-component">
 
    <form class="form-horizontal smileForm" id="SmileForm" name="SmileForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
        <fieldset>
            <legend>School Details</legend>
            <?php if(!empty($positiveMessages)){?>
            <div class="positiveMessages"> <?php echo $positiveMessages; ?></div>
            <?php } ?>
            <?php if(!empty($negativeMessages)){?>
            <div class="negativeMessages"> <?php echo $negativeMessages; ?></div>
            <?php } ?>
            <div class="form-group">
                <label class="col-lg-2 "  for="existingSchools">Existing Schools</label>
                <div class="col-lg-10">
                    <?php echo createDropdown($dbo->GetSchools(), 'existingSchools', 'existingSchools',(isset($_POST['existingSchools']) && !empty($_POST['existingSchools']))?$_POST['existingSchools']:'', 1,'form-control', true);?>
                   
                </div>
            </div>

                 <div class="form-group">
                <label class="col-lg-2 control-label" for="schoolName">School Name</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="schoolName" id="schoolName" value="<?php echo isset($school->school_name) ? $school->school_name : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Address 1</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="schoolAddress1" id="schoolAddress1"  value="<?php echo isset($school->school_address1) ? $school->school_address1 : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label"  for="">Address 2</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="schoolAddress2" id="schoolAddress2"  value="<?php echo isset($school->school_address2) ? $school->school_address2 : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">City</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="schoolCity" id="schoolCity"  value="<?php echo isset($school->school_city) ? $school->school_city : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Zip Code</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control" name="schoolZip" id="schoolZip"  value="<?php echo isset($school->school_zip) ? $school->school_zip : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for"county">County</label>
                <div class="col-lg-10">
                    <select id="county" name="county" class="form-control">
                    <?php
                        foreach($counties as $county){
                            if($school->school_county == $county)
                                echo "<option selected>{$county}</option>";
                            else
                                echo "<option>{$county}</option>";
                        }
                    ?>
                    </select>
                </div>        
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Phone</label>
                <div class="col-lg-10">
                    <input type="text" class="form-control phone" name="schoolPhone" id="schoolPhone"  value="<?php echo isset($school->school_phone) ? $school->school_phone : ''; ?>">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2" style="text-align:center">
                  <input type="button" name="clearme"  value="clear" id="clearme"/>  <input type="submit" value="submit" id="addSchool" name="addschool">
                </div>
            </div>
            
           
        </fieldset>
        <input type="hidden" id="schoolId" name="schoolId" value="<?php echo isset($school->id) ? $school->id : ''; ?>">
 
    
    </form>
  </div>
  

<?php
 include('includes/footer.php');
 ?>
