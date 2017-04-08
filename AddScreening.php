<?php 
    include('includes/header.php');
    $dbo->DoQuery('call getActiveSchoolsForDrop()');
    $rows = $dbo->resultset();

    $screening = new Screening();
    $existingScreening;
    if(isset($_REQUEST['SchoolScreenings']) && !empty($_REQUEST['SchoolScreenings'])){
        try{
            $existingScreening = new Screening();
            $sql = "select screeningId, screeningStartDate, schoolId, totalExams, totalNumberOfStudents,
            screeningStartDate,screeningEndDate, educationStartDate, educationEndDate, totalScreeningDays,
            totalEducationDays, schoolContactName, schoolContactEmail, totalNumberOfFluorideTreatments
            from screenings where screeningId='" . $_REQUEST['SchoolScreenings'] ."'";
            $currentScreening = $_REQUEST['SchoolScreenings'];
            $existingScreening = $dbo->queryForObjs($sql, 'screening');
            $screening= $existingScreening[0];
    

        }       
        catch (Exception$ex){
            $negativeMessage = $ex->getMessage();
        }
    }

    if(isset($_POST['addScreening'])) 
    { 
        try{
            $screening->schoolId=$_POST['schoolSelect'];
            $screening->totalExams=empty($_POST['totalExams'])?null:$_POST['totalExams'];
            $screening->totalNumberOfStudents=empty($_POST['totalStudents'])?null:$_POST['totalStudents'];
            $screening->totalNumberOfFluorideTreatments=empty($_POST['totalFluorideTreatments'])?null:$_POST['totalFluorideTreatments'];
            $screening->screeningStartDate=empty($_POST['screeningStartDate'])?NULL:date($_POST['screeningStartDate']);
            $screening->screeningEndDate=empty($_POST['screeningEndDate'])?NULL:date($_POST['screeningEndDate']);
            $screening->educationStartDate=empty($_POST['educationStartDate'])?NULL:date($_POST['educationStartDate']);
            $screening->educationEndDate=empty($_POST['educationEndDate'])?NULL:date($_POST['educationEndDate']);
            $screening->totalScreeningDays=empty($_POST['screeningDays'])?null:$_POST['screeningDays'];
            $screening->totalEducationDays=empty($_POST['educationDays'])?null:$_POST['educationDays'];
            $screening->schoolContactName=$_POST['schoolContact'];
            $screening->schoolContactEmail=$_POST['schoolContactEmail'];
            $idVar = (!empty($screening->educationStartDate)) ? date("Ymd", strtotime(date($screening->educationStartDate))) : date("Ymd", strtotime(date($screening->screeningStartDate)));
            $screening->screeningId= $screening->schoolId . "-" . $idVar; 

            //echo date("F Y",strtotime($screening->educationStartDate));


            if(empty($screening->screeningStartDate) && empty($screening->educationStartDate))
                throw new Exception('School must be selected and either a screening start date or an education start date must be entered.');
            
            if(empty($_POST['screeningID'])){
                $dbo->AddScreening($screening);
                $positiveMessages = "Screening Id '" . $screening->screeningId . "' added successfullly.";
            }
            else{
                $dbo->UpdateScreening($screening);
                $positiveMessages = "'" . $screening->screeningId . "' updated successfullly.";
            }
            $_POST = array();

            unset($screening);
        }
        catch (Exception $ex)
        {
            $negativeMessages = $ex->getMessage();
        }
    }
    
    ?>
<div class="well bs-component">
    <form style="background-color:#"  action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" class="form-horizontal smileForm" id="SmileForm" name="SmileForm" method="post">
    <fieldset>
            <legend>Screening Details</legend>
            <?php if(!empty($positiveMessages)){?>
            <div class="positiveMessages"> <?php echo $positiveMessages; ?></div>
            <?php } ?>
            <?php if(!empty($negativeMessages)){?>
            <div class="negativeMessages"> <?php echo $negativeMessages; ?></div>
            <?php } ?>
        <div class="form-group">                
                <label for="SchoolScreenings" class="col-lg-2 control-label">School Screening</label>
    
                
                <div  class="col-lg-10">
                <div class="hint">To edit an existing screening, select from the list. To add a new screening skip this field.</div>
                <?php echo createDropdown($dbo->GetSchoolScreenings(), 'SchoolScreenings', 'SchoolScreenings',isset($_POST['SchoolScreenings'])?$_POST['SchoolScreenings']:'', 1,'form-control', true);?>

                </div>
            </div>

        <div class="form-group">
                <label class="col-lg-2 control-label" for"county">school</label>
                <div class="col-lg-10">
                    <select id="schoolSelect" name="schoolSelect" class="form-control">
                    <option/>
                    <?php
  
                        foreach($rows as $row){
                            if( isset($screening) && $screening->schoolId == $row['val'])
                                echo "<option value='{$row['val']}' selected>{$row['txt']}</option>";
                            else
                                echo "<option value='{$row['val']}'>{$row['txt']}</option>";                                                       
                        }
                    ?>
                    </select>
                </div>        
            </div>
        <div class="form-group">
            <label class="col-lg-2 control-label" for="">education start date</label>
            <div class="col-lg-10">
                <input type="text" class="form-control datemask" name="educationStartDate" id="educationStartDate" value="<?php echo isset($screening->educationStartDate) ? $screening->educationStartDate : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">education end date</label>
            <div class="col-lg-10">
                <input type="text" class="form-control datemask" name="educationEndDate" id="educationEndDate" value="<?php echo isset($screening->educationEndDate) ? $screening->educationEndDate : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">total # education days</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="educationDays" id="educationDays" value="<?php echo isset($screening->totalEducationDays) ? $screening->totalEducationDays : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">screening start date</label>
            <div class="col-lg-10">
                <input type="text" class="form-control datemask" name="screeningStartDate" id="screeningStartDate" value="<?php echo isset($screening->screeningStartDate) ? $screening->screeningStartDate : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">screening end date</label>
            <div class="col-lg-10">
                <input type="text" class="form-control datemask" name="screeningEndDate" id="screeningEndDate" value="<?php echo isset($screening->screeningEndDate) ? $screening->screeningEndDate : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">total # screeening days</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" id="screeningDays" name="screeningDays" value="<?php echo isset($screening->totalScreeningDays) ? $screening->totalScreeningDays : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">total # exams</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="totalExams" id="totalExams" value="<?php echo isset($screening->totalExams) ? $screening->totalExams : ''; ?>">
            </div>
        </div>
         <div class="form-group">
            <label class="col-lg-2 control-label" for="">total # fluoride treatments</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="totalFluorideTreatments" id="totalFluorideTreatments" value="<?php echo isset($screening->totalNumberOfFluorideTreatments) ? $screening->totalNumberOfFluorideTreatments : ''; ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label class="col-lg-2 control-label" for="">total # students</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="totalStudents" id="totalStudents" value="<?php echo isset($screening->totalNumberOfStudents) ? $screening->totalNumberOfStudents : ''; ?>"> 
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">school contact</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="schoolContact" id="schoolContact" value="<?php echo isset($screening->schoolContactName) ? $screening->schoolContactName : ''; ?>">
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg-2 control-label" for="">school contact email</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="schoolContactEmail" id="schoolContactEmail" value="<?php echo isset($screening->schoolContactEmail) ? $screening->schoolContactEmail : ''; ?>">
            </div>
        </div>
      
       <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2" style="text-align:center">
                <input type="button" name="clearme"  value="clear" id="clearme"/>  <input type="submit" value="submit" id="addScreening" name="addScreening">
            </div>
        </div>
</fieldset>
<input type="hidden" id="screeningID" name="screeningID" value="<?php echo isset($screening->screeningId) ? $screening->screeningId : ''; ?>">
    </form>
</div>  

<?php
 include('includes/footer.php');
 ?>