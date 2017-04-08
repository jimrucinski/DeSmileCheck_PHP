<?php 
    include('includes/header.php');
    if(isset($_POST['submit'])) 
    { 
        $selectedSchool = $_POST['SchoolScreenings'];
        //$rows =$dbo->GetStudentsForSchools($selectedSchool);

        $schoolScreening = explode("-", $selectedSchool);//explode this because the school ID is the first part of the value of the screening field
        $student = new Student();
        $student->parent_fName = $_POST["parent_fName"];
        $student->parent_lName = $_POST["parent_lName"];
        $student->parent_address1 = $_POST["parent_address1"];
        $student->parent_address2 = $_POST["parent_address2"];
        $student->parent_city = $_POST["parent_city"];
        $student->parent_state = "DE";
        $student->parent_zip= $_POST["parent_zip"];
        $student->parent_phone=$_POST["parent_phone"];
        $student->student_fName=$_POST["student_fName"];
        $student->student_lName=$_POST["student_lName"];
        $student->student_grade=$_POST["student_grade"];
        $student->student_DOB = $_POST["student_DOB"];
        $student->student_race= $_POST["student_race"];          
        $student->student_teacher = $_POST["student_teacher"];
        $student->student_grade = $_POST["student_grade"];      
        $student->student_allergies = $_POST["student_allergies"];
        $student->student_medicalConditions = $_POST["student_medicalConditions"];
        $student->screeningId =  $_POST['SchoolScreenings'];
        $student->student_school=(int)($schoolScreening[0]);
        $student->created_at = date("Y-m-d H:i:s");
        $dbo->AddStudentScreening($student);

    
    }
 
?>
    <div class="well bs-component">
    <form class="form-horizontal smileForm" is="SmileForm" name="SmileForm" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
    <fieldset>
        <legend>Student Profile</legend>   
    <div class="form-group">
        <label class="control-label col-lg-10" for="school">School</label>
    <div  class="col-lg-10">
    <?php 
       // $dbo->DoQuery('call getSchoolScreenings()');
       $dbo->DoQuery('select id as id, school_name as val from schools where is_active=1 order by school_name;');
        $rows = $dbo->resultset();
        echo createDropdown($rows, 'SchoolScreenings', 'SchoolScreenings', isset($selectedSchool)?$selectedSchool:null, 1, 'form-control',true);?>
        </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_fName">Parent First Name</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_fName" id="parent_fName">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_lName">Parent Last Name</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_lName" id="parent_lName">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_address1">Parent Address 1</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_address1" id="parent_address1">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_address2">Parent Address 2</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_address2" id="parent_address2">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_city">Parent City</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_city" id="parent_city">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_zip">Parent Zip</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_zip" id="parent_zip">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="parent_phone">Parent Primary Phone</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="parent_phone" id="parent_phone">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="student_fName">Student First Name</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="student_fName" id="student_fName">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="student_lName">Student Last Name</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="student_lName" id="student_lName">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-lg-10" for="student_teacher">Student Teacher</label>
            <div class="col-lg-10">
                <input type="input" class="form-control" name="student_teacher" id="student_teacher">
            </div>
        </div>
        <div class="form-group row"><label class="control-label col-lg-10" for="student_grade">Grade</label>
            <div class="col-lg-10">
            <input type="input" class="form-control" name="student_grade" id="student_grade"></div>
            </div>
        <div class="form-group row">
            <label class="control-label col-lg-10" for="student_DOB">Date of Birth</label>
            <div class="col-lg-10">
            <input type="input" class="form-control datemask" name="student_DOB" id="student_DOB">
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-lg-10" for="student_race">Race</label>
            <div class="col-lg-10">
            <select id="student_race" name="student_race" class="form-control"><option/>
            <?php
 
                foreach ($races as $race){
                    echo "<option>{$race}</option>";
                }
   
            ?>
            </select>
            </div>
        </div>
        <div class="form-group row"><label class="control-label col-lg-10" for"student_allergies">Allergies</label>
           <div class="col-lg-10"><textarea id="" name="student_allergies" class="form-control"></textarea></div>
        </div>
        <div class="form-group row"><label class="control-label col-lg-10" for"student_medicalConditions">Medical Conditions</label>
           <div class="col-lg-10"> <textarea id="student_medicalConditions" name="student_medicalConditions" class="form-control"></textarea></div>
        </div>
        <div class="form-group row">
        <div class="col-lg-10" style="text-align:center;"><br/><input type="submit" value="Submit" id="addStudent" name="submit"></div>
        </div>
        </fieldset>
      
    </form>
</div>
<?php 
    include('includes/footer.php');
    ?>