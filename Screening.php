<?php 
    include('includes/header.php');
    if(isset($_POST['submit'])) 
    { 
        $selectedSchool = $_POST['SchoolScreenings'];
        $rows =$dbo->GetStudentsForSchools($selectedSchool);
        $schoolScreening = explode("|", $selectedSchool);
        $student = new Student();
        $student->FirstName=$_POST["studentFname"];
        $student->LastName=$_POST["studentLname"];
        $student->Grade=$_POST["studentGrade"];
        $student->DOB = $_POST["studentDOB"];
        $student->StudentRace = $_POST["studentRace"];                
        $student->StudentAllergies = $_POST["studentAllergies"];
        $student->StudentMedicalConditions = $_POST["studentMedicalConditions"];
        $student->ScreeningId = $schoolScreening[1];
        $student->School=$schoolScreening[0];

        $dbo->AddStudentScreening($student);

    
    }

?>
    <form class="form-horizontal" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
        
    <div class="form-group"><label class="control-label col-sm-2" for="school">School Screening</label>
    <div  class="col-sm-10">
    <?php 
        $dbo->DoQuery('call getSchoolScreenings()');
        $rows = $dbo->resultset();
        echo createDropdown($rows, 'SchoolScreenings', 'SchoolScreenings', isset($selectedSchool)?$selectedSchool:null, 1, 'form-control');?>
        </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="studentFname">First Name</label>
            <div class="col-sm-10">
                <input type="input" class="form-control" name="studentFname" id="studentFname">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="studentLname">Last Name</label>
            <div class="col-sm-10">
                <input type="input" class="form-control" name="studentLname" id="studentLname">
            </div>
        </div>
        <div class="form-group row"><label class="control-label col-sm-2" for="studentGrade">Grade</label>
            <div class="col-sm-10">
            <input type="input" class="form-control" name="studentGrade" id="studetnGrade"></div>
            </div>
        <div class="form-group row">
            <label class="control-label col-sm-2" for="studentDOB">Date of Birth</label>
            <div class="col-sm-10">
            <input type="input" class="form-control" name="studentDOB" id="studentDOB">
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-sm-2" for="studentRace">Race</label>
            <div class="col-sm-10">
            <select id="studentRace" name="studentRace" class="form-control"><option/>
            <?php
                foreach ($races as $race){
                    echo "<option>{$race}</option>";
                }
            ?>
            </select>
            </div>
        </div>
        <div class="form-group row"><label class="control-label col-sm-2" for"studentAllergies">Allergies</label>
           <div class="col-sm-10"><textarea id="" name="studentAllergies" class="form-control"></textarea></div>
        </div>
        <div class="form-group row"><label class="control-label col-sm-2" for"studentMedicalConditions">Medical Conditions</label>
           <div class="col-sm-10"> <textarea id="studentMedicalConditions" name="studentMedicalConditions" class="form-control"></textarea></div>
        </div>
        <div class="form-group row">
        <div class="col-sm-10" style="text-align:center;"><input type="submit" value="add school" id="addSchool" name="submit"></div>
        </div>
    </form>
