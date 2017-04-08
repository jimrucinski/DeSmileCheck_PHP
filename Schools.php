<?php include('includes/header.php'); 

$rows = $dbo->GetAllSchools();
    
?>

<table id="ReviewSchoolsTable">
    <tr><th>Screening</th><th>School</th><th>Phone</th><th>Education</th><th>Total Students</th><th>Total Exams</th><th>Fluoride Treatments</th><th>Fluoride Treatments</th><th>%Students Examined</th></tr>
    <?php 
    $tbl = "";
    foreach($rows as $row){
        $tbl .= "<tr><td><a href='screening.php?id={$row['screeningId']}'>{$row['screeningStartDate']}</a></td><td><a href='addschool.php?existingSchools={$row['id']}'>{$row['school_name']}</a></td><td>{$row['school_phone']}</td>
                <td>{$row['educationStartDate']}</td><td>{$row['totalNumberOfStudents']}</td><td>{$row['totalExams']}</td>
                <td>{$row['totalNumberOfFluorideTreatments']}</td><td>" . getPercent($row['totalNumberOfFluorideTreatments'],$row['totalExams']) . "</td><td>" . getPercent($row['totalExams'], $row['totalNumberOfStudents']) . "</td></tr>";
    }
    echo $tbl;
    ?>
    </table>
<?php include('includes/footer.php');?>