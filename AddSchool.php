<?php 
    include('includes/header.php');
    if(isset($_POST['submit'])) 
    { 
    //$selectedSchool = $_POST['schools'];
    //$rows =$dbo->GetStudentsForSchools($selectedSchool);
    $school = new School();
    $school->school_name=$_POST['schoolName'];
    $school->school_address1=$_POST['schoolAddress1'];
    $school->school_address2=$_POST['schoolAddress2'];
    $school->school_city = $_POST['schoolCity'];
    $school->school_zip = $_POST['schoolZip'];
    $school->school_county = $_POST['county'];
    $school->school_phone = $_POST['schoolPhone'];
    $school->school_contact = $_POST['schoolContact'];
    $dbo->AddSchool($school);

    }
    ?>
<div class="contatiner">
    <form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
    <div class="form-group row"><label class="col-2 col-form-label" for="schoolName">School Name</label><input type="input" class="form-control" name="schoolName" id="schoolName"></div>
    <div class="form-group row"><label class="col-2 col-form-label" for="">Address 1</label><input type="input" class="form-control" name="schoolAddress1" id="schoolAddress1"></div>
    <div class="form-group row"><label class="col-2 col-form-label"  for="">Address 2</label><input type="input" class="form-control" name="schoolAddress2" id="schoolAddress2"></div>
    <div class="form-group row"><label class="col-2 col-form-label" for="">City</label><input type="input" class="form-control" name="schoolCity" id="schoolCity"></div>
    <div class="form-group row"><label class="col-2 col-form-label" for="">Zip Code</label><input type="input" class="form-control" name="schoolZip" id="schoolZip"></div>
    <div class="form-group row"><label class="col-2 col-form-label" for"county">County</label>
        <select id="county" name="county">
        <?php
            foreach($counties as $county){
                echo "<option>{$county}</option>";
            }
        ?>
        </select>
   
    </div>
    <div class="form-group row"><label class="col-2 col-form-label" for="">Phone</label><input type="input" class="form-control" name="schoolPhone" id="schoolPhone"></div>
    <div class="form-group row"><label class="col-2 col-form-label" for="">Contact Name</label><input type="input" class="form-control" name="schoolContact" id="schoolContact"></div>
    <div class="form-group row"><input type="submit" value="add school" id="addSchool" name="submit"></div>
    </form>
</div>
