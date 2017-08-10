<?php
namespace m2i\project\Model\Entity;

class CoursesScheduleDTO {

    private static $columnMap = [
       'session_id' => 'sessionId', 
'course_id' => 'courseId', 
'classroom_id' => 'classroomId', 
'start_date' => 'startDate', 
'end_date' => 'endDate'
    ];

    private $sessionId;
private $courseId;
private $classroomId;
private $startDate;
private $endDate;

    public function __set($name, $value)
    {
        if(array_key_exists($name, self::$columnMap)){
            $attributeName = self::$columnMap[$name];
            $this->$attributeName = $value;
        }
    }

    public function hydrate(array $data)
    {
        foreach ($data as $key => $val) {
            $methodName = "set" . ucfirst($key);
            if (method_exists($this, $methodName)) {
                $this->$methodName($val);
            } else {
                if (array_key_exists($key, self::$columnMap)) {
                    $methodName = $methodName = "set" . ucfirst(self::$columnMap[$key]);
                    $this->$methodName($val);
                }
            }
        }
    }



    public function setId($sessionId){
            $this->sessionId = $sessionId;
            return $this;
        }
public function getId(){
            return $this->sessionId;
        }
public function setId($courseId){
            $this->courseId = $courseId;
            return $this;
        }
public function getId(){
            return $this->courseId;
        }
public function setClassroomId($classroomId){
            $this->classroomId = $classroomId;
            return $this;
        }
public function getClassroomId(){
            return $this->classroomId;
        }
public function setStartDate($startDate){
            $this->startDate = $startDate;
            return $this;
        }
public function getStartDate(){
            return $this->startDate;
        }
public function setEndDate($endDate){
            $this->endDate = $endDate;
            return $this;
        }
public function getEndDate(){
            return $this->endDate;
        }



}