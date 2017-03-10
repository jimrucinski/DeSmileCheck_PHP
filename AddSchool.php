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
    <div class="well bs-component">
    <form style="background-color:#" class="form-horizontal" action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
        <fieldset>
            <legend>Form Title Here</legend>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="schoolName">School Name</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolName" id="schoolName">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Address 1</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolAddress1" id="schoolAddress1">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label"  for="">Address 2</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolAddress2" id="schoolAddress2">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">City</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolCity" id="schoolCity">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Zip Code</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolZip" id="schoolZip">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for"county">County</label>
                <div class="col-lg-10">
                    <select id="county" name="county" class="form-control">
                    <?php
                        foreach($counties as $county){
                            echo "<option>{$county}</option>";
                        }
                    ?>
                    </select>
                </div>        
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Phone</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolPhone" id="schoolPhone">
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label" for="">Contact Name</label>
                <div class="col-lg-10">
                    <input type="input" class="form-control" name="schoolContact" id="schoolContact">
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2" style="text-align:center">
                    <input type="submit" value="add school" id="addSchool" name="submit">
                </div>
            </div>
        </fieldset>
    </form>
    </div>


<?php
 include('includes/footer.php');
 ?>
