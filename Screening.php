<?php include('includes/header.php'); 

$screening = new Screening();    
    //$editMode=false;

        if($_REQUEST["id"] != "") {
        try{
            $screeningId = $_REQUEST["id"];
            $rows = $dbo->GetScreeningDetails($screeningId);            
            $schoolDets = "<td><a href=AddScreening.php?SchoolScreenings={$screeningId}>{$rows[0]['school_name']}</a></td><td>{$rows[0]['educationStartDate']}<br/>{$rows[0]['totalEducationDays']} -day(s)</td>
            <td>{$rows[0]['screeningStartDate']}<br/>{$rows[0]['totalScreeningDays']} -day(s)</td><td>{$rows[0]['totalNumberOfStudents']}</td>
            <td>{$rows[0]['totalNumberOfFluorideTreatments']}</td><td>{$rows[0]['totalExams']}</td><td>{$rows[0]['schoolContactName']}<br/>{$rows[0]['schoolContactEmail']}</td>";
           
            $students = $dbo->GetStudentsForScreening( $screeningId);
            
            $studentDets="";
            foreach($students as $student){
                $studentDets .= "<tr><td>{$student['student_lName']}, {$student['student_fName']}</td>
                <td>{$student['immediate_care_needed']}</td><td>{$student['cavities_suspected']}</td>
                <td>{$student['needs_cleaning']}</td>
                <td>{$student['improve_brushing']}</td>
                <td>{$student['regular_checkup_needed']}</td>
                <td>{$student['exam_remarks']}</td></tr>";
            }

      

        }
       
        catch (Exception$ex){

        }
    }
   
    
?>
<h4>Screening Information</h4>
<table>
    <tr><th>School</th><th>Education</th><th>Screening</th><th>Number of Students</th><th>Fluoride Treatments</th><th>Number of Exams</th><th>Contact</th></tr>
    <tr>
        <?php
        echo $schoolDets;
        ?>
    </tr>
    <tr>
        <td colspan="7">
            <table id="StudentScreeningDetails">
            <tr><th>Student</th><th>immediate care needed</th><th>cavities suspected</th><th>needs cleaning</th><th>improve brushing</th><th>checkup needed</th><th>remarks</th></tr>
            <?php echo $studentDets?>
                </table>
        </td>
</table>
<?php include('includes/footer.php');?>