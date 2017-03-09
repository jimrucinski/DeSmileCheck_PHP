<?php 
    include('includes/header.php');
    if(isset($_POST['submit'])) 
    { 
    $selectedSchool = $_POST['schools'];
    $rows =$dbo->GetStudentsForSchools($selectedSchool);
    
    }

/*
    $sql = 'call getStudentsBySchool(3)';
    $dbo->query($sql);
    $rows = $dbo->resultset();


    foreach($rows as $row){
        echo $row['student_fName'] . '<br/>';
    }

    $rows = $dbo->GetSchools();
    foreach($rows as $row){
        echo $row['id'] . '<br/>';
    }
*/
    
?>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">

    <ul>
        <li><?php echo createDropdown($dbo->GetSchools(), 'schools', 'schools', isset($selectedSchool)?$selectedSchool:null, 1,'');?></li>
        <li><input type="submit" name="submit" value="go"/>
    </ul>
<?php if(isset($_POST['submit'])){ ?>
    <table class="table table-striped">
        <thead>            
            <th>last name</th>
            <th>first name</th>
            <th>grade</th>
            <th>race</th>
            <th>D.O.B.</th>
            <th>teacher</th>
            <th>allergies</th>
            <th>medical conditions</th>
        </thead>
        <?php
        foreach($rows as $row){
            echo '<tr><td><a href=student.php?id=' . $row['student_id'] . '>' . $row['student_lName'] . '</a></td><td>' . $row['student_fName'] . '</td><td>' . $row['student_grade'] . '</td><td>';
            echo $row['race'] . '</td><td>' . $row['student_DOB'] . '</td><td>' . $row['student_teacher'] . '</td><td>';
            echo $row['student_allergies'] . '</td><td>'. $row['student_medicalConditions'] . '</td></tr>';
         
        }
        ?>
    </table>
    <?php } ?>
</form>

