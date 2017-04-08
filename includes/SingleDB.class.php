<?php

//
//Singleton Database Methodology
//
    class SingleDB{
        protected static $db;            
        private $host;
        private $user;
        private $pass;
        private $dbName;            
        private static $instance = "";            
        private $connection;
        private $results;
        private $numRows;
        private $stmt;            
        
        static function getInstance()
        {
            if(!self::$instance){//if there is no instance of itself
              self::$instance = new self(); //create one 
            }
            return self::$instance;
        }
        private function __construct(){
           
        }

        function connect($host, $user, $password, $dbName){
            $this -> user = $user;
            $this -> pass = $password;
            $this -> dbName =$dbName;
            $this -> host = $host;                    
            try{
                $dsn = 'mysql:host=' . $host .';dbname=' . $dbName ;
                self::$db = new PDO($dsn, $user, $password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);        
                
            } catch (PDOException $ex) {
                throw new customException($ex);
                //echo "connection error: " . $ex->getMessage();
            }
        }      

        public function GetSchools()
        {
            $out=0;
            try{
                $sql = 'select id as id, school_name as val from schools order by school_name';
                $this->query($sql);                
                return $this->resultset();
                
            } catch(PDOException $e){
                echo $e->getMessage();
                //die();
            }    
        }

        public function AddStudentScreening($student){
            try{
                $this->stmt=self::$db->prepare('CALL addStudentScreening(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$student->student_fName);
                $this->stmt->bindParam(2,$student->student_lName);
                $this->stmt->bindParam(3,$student->student_grade);
                $this->stmt->bindParam(4,$student->student_DOB);
                $this->stmt->bindParam(5,$student->student_race);                
                $this->stmt->bindParam(6,$student->student_allergies);
                $this->stmt->bindParam(7,$student->student_medicalConditions);
                $this->stmt->bindParam(8,$student->student_school);
                $this->stmt->bindParam(9,$student->student_teacher);
                $this->stmt->bindParam(10,$student->parent_fName);
                $this->stmt->bindParam(11,$student->parent_lName);
                $this->stmt->bindParam(12,$student->parent_address1);
                $this->stmt->bindParam(13,$student->parent_address2);
                $this->stmt->bindParam(14,$student->parent_city);
                $this->stmt->bindParam(15,$student->parent_state);
                $this->stmt->bindParam(16,$student->parent_zip);
                $this->stmt->bindParam(17,$student->parent_phone);
                $this->stmt->bindParam(18,$student->created_at);
                $this->stmt->execute();
            }
            catch(PDOException $ex){
                echo $ex->getMessage();
                throw new Exception($ex);
            }
        }

        public function AddSchool($school){
           try{
                $this->stmt = self::$db->prepare('CALL addSchool(?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$school->school_name);
                $this->stmt->bindParam(2,$school->school_address1);
                $this->stmt->bindParam(3,$school->school_address2);
                $this->stmt->bindParam(4,$school->school_city);
                $this->stmt->bindParam(5,$school->school_zip);
                $this->stmt->bindParam(6,$school->school_county);
                $this->stmt->bindParam(7,$school->school_phone);
                $this->stmt->execute();   
           }
           catch(PDOException $e){
               if (isset($e->errorInfo[1]) && $e->errorInfo[1] === 1062) {
                   throw new Exception("Duplicate Entry. School Already Exists.", 1062);
                    /* perform UPDATE instead */
                }
                else
                    throw new Exception($e->getMessage());
            }           
        }

        public function AddExam($exam){
            
                $this->stmt = self::$db->prepare('Call addExam(?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$exam->student_id);
                $this->stmt->bindParam(2,$exam->screening_id);
                $this->stmt->bindParam(3,$exam->immediate_care_needed);
                $this->stmt->bindParam(4,$exam->cavities_suspected);
                $this->stmt->bindParam(5,$exam->needs_cleaning);
                $this->stmt->bindParam(6,$exam->improve_brushing);
                $this->stmt->bindParam(7,$exam->regular_checkup_needed);
                $this->stmt->bindParam(8,$exam->exam_remarks);
                $this->stmt->execute();

         
        }

        public function AddSchoolComment($schoolId, $schoolComment){
            $this->stmt = self::$db->prepare('CALL addComment(?,?)');
            $this->stmt->bindParam(1,$schoolId);
            $this->stmt->bindParam(2,$schoolComment);
            $this->stmt->execute();
        }

        public function UpdateSchool($school)
        {
            try{
                 $this->stmt = self::$db->prepare('CALL updateSchool(?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$school->schoolId);
                $this->stmt->bindParam(2,$school->school_name);
                $this->stmt->bindParam(3,$school->school_address1);
                $this->stmt->bindParam(4,$school->school_address2);
                $this->stmt->bindParam(5,$school->school_city);
                $this->stmt->bindParam(6,$school->school_zip);
                $this->stmt->bindParam(7,$school->school_county);
                $this->stmt->bindParam(8,$school->school_phone);
                $this->stmt->execute();   
           }
           catch(PDOException $e){
               throw new Exception($e->getMessage());
            }           
        }

        public function AddScreening($screening){
           try{
                $this->stmt = self::$db->prepare('CALL addScreening(?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$screening->screeningId);
                $this->stmt->bindParam(2,$screening->schoolId);
                $this->stmt->bindParam(3,$screening->totalExams);
                $this->stmt->bindParam(4,$screening->totalNumberOfStudents);
                $this->stmt->bindParam(5,$screening->screeningStartDate);
                $this->stmt->bindParam(6,$screening->screeningEndDate);
                $this->stmt->bindParam(7,$screening->educationStartDate);
                $this->stmt->bindParam(8,$screening->educationEndDate);
                $this->stmt->bindParam(9,$screening->totalScreeningDays);
                $this->stmt->bindParam(10,$screening->totalEducationDays);
                $this->stmt->bindParam(11,$screening->schoolContactName);
                $this->stmt->bindParam(12,$screening->schoolContactEmail);
                $this->stmt->bindParam(13,$screening->totalNumberOfFluorideTreatments);
                $this->stmt->execute();   
           }
           catch(PDOException $e){
            throw new Exception($e->getMessage());
            }           
        }

        public function UpdateScreening($screening){
           try{
                $this->stmt = self::$db->prepare('CALL updateScreening(?,?,?,?,?,?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$screening->screeningId);
                $this->stmt->bindParam(2,$screening->schoolId);
                $this->stmt->bindParam(3,$screening->screeningStartDate);
                $this->stmt->bindParam(4,$screening->screeningEndDate);
                $this->stmt->bindParam(5,$screening->totalScreeningDays);
                $this->stmt->bindParam(6,$screening->educationStartDate);
                $this->stmt->bindParam(7,$screening->educationEndDate);
                $this->stmt->bindParam(8,$screening->totalEducationDays);
                $this->stmt->bindParam(9,$screening->totalExams);
                $this->stmt->bindParam(10,$screening->totalNumberOfStudents);
                $this->stmt->bindParam(11,$screening->schoolContactName);
                $this->stmt->bindParam(12,$screening->schoolContactEmail);
                $this->stmt->bindParam(13,$screening->totalNumberOfFluorideTreatments);
                $this->stmt->execute();   
           }
           catch(PDOException $e){
            throw new Exception($e->getMessage());
            }           
        }

        public function GetStudentsForSchools($schoolId){
            try{
                $sql = "select students.student_id, students.updated_at,students.student_fName,students.student_lName,races.race,
                        students.student_DOB,
                        schools.school_name,students.student_teacher, students.student_grade, students.parent_fName, 
                        students.parent_lName, students.parent_address1, students.parent_address2, students.parent_city, 
                        students.parent_state, students.parent_zip, students.parent_phone, students.student_allergies,
                        students.student_medicalConditions
                        from students
                        join races on students.student_race = races.id
                        join schools on students.student_school = schools.id
                        where students.student_school=" . $schoolId . " order by students.student_lName";
     
                $this->query($sql);                
                return $this->resultset();
                
            } catch(PDOException $e){
                echo $e->getMessage();
                //die();
            }    
        }

        public function GetSchool($schoolId){
            try{
                $sql = "select id, school_name, school_address1, school_address2, school_city, school_zip,
                        school_county, school_phone from schools where id=" . $schoolId;
     
                $this->query($sql);                
                return $this->resultset();
                
            } catch(PDOException $e){
                echo $e->getMessage();
                //die();
            }    
        }
        public function GetSchoolComments($schoolId){
            try{
                $sql = "select comment_id, date_added, school_id, comment from schoolcomments where school_id=" . $schoolId;

                $this->query($sql);
                return $this->resultset();
            }
            catch(PDOException $e){
                throw new Exception($e->getMessage());
            }

        }
        public function GetSchoolStudentList($schoolId){
            try{
                $sql = "select student_id as id, concat(student_lName, ', ', student_fName) as val from students where student_school=" . $schoolId;
                $this->query($sql);
                return $this->resultset();
            }
            catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }
        public function GetSchoolScreenings(){
            try{
                $sql = "select screenings.screeningId as id, 
                CONCAT(schools.school_name, ' [ ' , DATE_FORMAT(SUBSTRING_INDEX(screenings.screeningId,'-',-1), '%Y %b') , ' ]') as val
                from screenings
                join schools on screenings.schoolId=schools.id
                where schools.is_active = 1
                order by screenings.educationStartDate desc, screenings.screeningStartDate desc";
                $this->query($sql);
                return $this->resultset();
            }
            catch(PDOException $e){
                throw new Exception($e->getMessage());
            }
        }
        public function GetSchoolScreeningDetails($screeningId){
            $sql = "select screeningId, screeningStartDate, schoolId, totalExams, totalNumberOfStudents,
            screeningStartDate,screeningEndDate, educationStartDate, educationEndDate, totalScreeningDays,
            totalEducationDays, schoolContactName, schoolContactEmail
            from screenings where screeningId='" . $screeningId ."'";
            $this->query($sql);
            return $this->resultset();
        }
        public function GetStudentDetails($studentId)
        {
            try{
                $sql = "select * from students where student_id = " . $studentId;     
                $this->query($sql);                
                return $this->resultset();
                
            } catch(PDOException $e){
                echo $e->getMessage();
                //die();
            }    
        }
        public function GetAllSchools(){
            try{
                $sql = "SELECT schools.id, schools.school_name, schools.school_phone,
                screenings.screeningId, screenings.screeningStartDate,screenings.educationStartDate,
                screenings.totalNumberOfStudents, screenings.totalExams, screenings.totalNumberOfFluorideTreatments, screenings.screeningId
                FROM
                schools
                JOIN screenings on schools.id = screenings.schoolid
                order by screenings.screeningStartDate DESC, screenings.educationStartDate DESC";
                $this->query($sql);
                return $this->resultset();
            }
            catch(PDOException $e){
                echo $e->getMessage();
            }
        }

        public function GetScreeningDetails($screeningId){
            $sql="select schools.school_name, screenings.screeningId,  screenings.screeningStartDate,  screenings.schoolId, 
                screenings.totalExams,  screenings.totalNumberOfStudents, 
                screenings.screeningStartDate, screenings.screeningEndDate,  screenings.educationStartDate, 
                screenings.educationEndDate,  screenings.totalScreeningDays, 
                screenings.totalEducationDays,  screenings.schoolContactName,  screenings.schoolContactEmail, screenings.totalNumberOfFluorideTreatments
                from screenings
                join schools on screenings.schoolId = schools.id
                where screeningId='" . $screeningId . "'";
                $this->query($sql);
                return $this->resultset();
        }

        public function GetStudentsForScreening($screeningId){
            $sql = "select studentexams.*, students.student_id, students.student_fName, students.student_lName
            from studentexams
            join students on studentexams.student_id = students.student_id
            where screening_id='" . $screeningId . "'";
            $this->query($sql);
            return $this->resultset();
        }
        public function ResultsetForObj($obj){
            echo 'here';
            var_dump($obj);
            try{
            $this->execute();
            $this->stmt->fetchALL(PDO::FETCH_CLASS, $obj);
            var_dump($obj);
            return $this->stmt->fetchAll();
            }
            catch(PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }

       public function queryForObjs($sql, $objName){
           try{
            $this->stmt = self::$db->prepare($sql);
            $this->stmt->execute();
            $this->stmt->setFetchMode(PDO::FETCH_CLASS, $objName);
           return $this->stmt->fetchAll();       
           }
           catch(PDOException $ex){
               echo $ex->getMessage();
           }     
        }
        public function resultset(){
            $this->execute();
            return $this->stmt->fetchALL(PDO::FETCH_ASSOC);
        }
        public function execute(){
            //$this->stmt->setFetchMode(PDO::FETCH_CLASS,'PmaTix');
            return $this->stmt->execute();
        }
        public function DoQuery($sql){
          $this->results = self::query($sql);
          //foreach(self::$db->query($sql) as $row){
          //          print_r($row);
          //}
        }
        public function query($sql){
            $this->stmt = self::$db->prepare($sql);
        }
    }
?>