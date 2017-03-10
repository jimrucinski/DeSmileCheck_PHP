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
                $this->stmt=self::$db->prepare('CALL addStudentScreening(?,?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$student->FirstName);
                $this->stmt->bindParam(2,$student->LastName);
                $this->stmt->bindParam(3,$student->Grade);
                $this->stmt->bindParam(4,$student->DOB);
                $this->stmt->bindParam(5,$student->StudentRace);                
                $this->stmt->bindParam(6,$student->StudentAllergies);
                $this->stmt->bindParam(7,$student->StudentMedicalConditions);
                $this->stmt->bindParam(8,$student->ScreeningId);
                $this->stmt->bindParam(9,$student->School);
                $this->stmt->execute();
            }
            catch(PDOException $e){
                throw new customException($ex);
            }
        }

        public function AddSchool($school){
           try{
                $this->stmt = self::$db->prepare('CALL addSchool(?,?,?,?,?,?,?,?)');
                $this->stmt->bindParam(1,$school->school_name);
                $this->stmt->bindParam(2,$school->school_address1);
                $this->stmt->bindParam(3,$school->school_address2);
                $this->stmt->bindParam(4,$school->school_city);
                $this->stmt->bindParam(5,$school->school_zip);
                $this->stmt->bindParam(6,$school->school_county);
                $this->stmt->bindParam(7,$school->school_phone);
                $this->stmt->bindParam(8,$school->school_contact);  
                $this->stmt->execute();   
           }
           catch(PDOException $e){
            echo $e->getMessage();
            //die();
            }           
        }

        public function AddScreening($screening){
           try{
               echo 'in proc';
                $this->stmt = self::$db->prepare('CALL addScreening(?,?,?)');
                $this->stmt->bindParam(1,$screening->SchoolId);
                $this->stmt->bindParam(2,$screening->ScreeningDate);
                $this->stmt->bindParam(3,$screening->TotalNumberOfExams);
                $this->stmt->execute();   
           }
           catch(PDOException $e){
            echo $e->getMessage();
            //die();
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