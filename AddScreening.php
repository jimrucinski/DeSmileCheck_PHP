<?php 
    include('includes/header.php');

    $dbo->DoQuery('call getActiveSchoolsForDrop()');
    $rows = $dbo->resultset();

    if(isset($_POST['submit'])) 
    { 
    echo('here');
    $screening = new Screening();
    $screening->SchoolId=$_POST['SchoolSelect'];
    $screening->ScreeningDate=$_POST['ScreeningDate'];
    $screening->TotalNumberOfExams = $_POST['NumberOfScreenings'];
    echo $screening->ScreeningDate;
    $dbo->AddScreening($screening);

    }
    
    ?>
<div>
    <form  action="<?php echo htmlentities($_SERVER['PHP_SELF']);?>" method="post">
        <div>
        <label>school</label>
        <select id="SchoolSelect" name="SchoolSelect">            
            <option selected>Choose...</option>
            <?php
                foreach($rows as $row){
                    echo "<option value='{$row['val']}'>{$row['txt']}</option>";
                }
            ?>
        </select>
        </div>
        <div>
            <label>screening date</label>
            <input type="text" id="ScreeningDate" name="ScreeningDate" />
        </div>
        <div>
            <label>total number of screenings</label>
            <input type="text" id="NumberOfScreenings" name="NumberOfScreenings"/>
        </div>
        
       

    <button type="submit" class="btn btn-primary" name="submit">Submit</button>


    </form>
</div>  
