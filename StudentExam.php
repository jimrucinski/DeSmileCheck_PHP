 <?php 
    include('includes/header.php');
    $exam = new Exam();
    $currentScreening = "";

if(isset($_POST['SchoolScreenings']) && !empty($_POST['SchoolScreenings'])){
        try{
            $currentScreening = $_POST['SchoolScreenings'];
            $schoolScreen = explode('-',$_POST['SchoolScreenings']);
            $dbo->GetSchoolStudentList($schoolScreen[0]);
            $rows = $dbo->resultset();
            $studentDrop= createDropdown($rows, 'SchoolStudents', 'SchoolStudents', isset($schoolStudent)?$schoolStudent:null, 1, 'form-control',false);       
        }       
        catch (Exception$ex){
            $negativeMessage = $ex->getMessage();
        }
    }

    if(isset($_POST['addExam'])) 
    { 
        $currentScreening = $_POST['SchoolScreenings'];
       
       $exam->student_id = $_POST["SchoolStudents"];
       $exam->screening_id=$_POST["SchoolScreenings"];
       foreach($examBits as $examBit){
           $action = $examBit[0];
           $actionValue = ISSET($_POST[$action])?$_POST[$action]:0;
           $exam->$action= $actionValue;
       }
       $exam->exam_remarks = $_POST["exam_remarks"];    
       try{    
       $dbo->AddExam($exam);
       $positiveMessages = "Exam added successfullly.";
        //throw new Exception('this failed miserably');        
        $_POST = array(); // clear the post data after successfully adding the record.
        unset($exam);
       }
       catch(Exception $ex){
           if(strpos($ex->getMessage(),"Integrity constraint violation: 1062"))
                $negativeMessages = "Screening and Student combination already exists.";
            else
                $negativeMessages=$ex->getMessage();           
        }   
       
    }

    


?>
<div class="well bs-component">
    <form class="form-horizontal smileForm" id="SmileForm" Name="SmileForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
 <?php if(!empty($positiveMessages)){?>
            <div class="positiveMessages"> <?php echo $positiveMessages; ?></div>
            <?php } ?>
            <?php if(!empty($negativeMessages)){?>
            <div class="negativeMessages"> <?php echo $negativeMessages; ?></div>
            <?php } ?>
 <fieldset>
           <legend>Add Student Exam</legend>
            <div class="form-group">
                <div  class="col-sm-10">
                <label for="SchoolScreenings" class="control-label col-lg-10">School Screening</label>
                <?php echo createDropdown($dbo->GetSchoolScreenings(), 'SchoolScreenings', 'SchoolScreenings',isset($currentScreening)?$currentScreening:'', 1,'form-control', true);?>

                </div>
            </div>
            <?php 
                if(isset($studentDrop)){
                    ?>
            <div class="form-group">
            <div  class="col-sm-10">
             <label for="examComments" class="control-label col-lg-10">Student</label>
             <div class="col-lg-10">
            <?php
                    echo $studentDrop;
               ?>
                </div>
            </div>
            <?php } ?>
            <div class="form-group-row"><label class="control-label col-lg-10" for="studentExamChecks">Exam Actions</label>
            <div class="col-sm-10">
            <ul class="noBull">
            <?php
                foreach($examBits as $examBit){
                    echo "<li><input type='checkbox' name='{$examBit[0]}' value='1'>{$examBit[1]}</li>";
                }
            ?>
            </ul>
            </div>
        </div>
        
        <div class="form-group-row"><label for="examComments" class="control-label col-lg-10">Exam Comments</label>
            <div class="col-sm-10"><textarea id="exam_remarks" name="exam_remarks" class="form-control"></textarea></div>
        </div>
        
        <div class="form-group row">
        <div class="col-sm-10" style="text-align:center;"><br/><input type="submit" value="Submit" id="addSchool" name="addExam"></div>
        </div>
        </fieldset>
        </form>
</div>

        
<?php
 include('includes/footer.php');
 ?>

        