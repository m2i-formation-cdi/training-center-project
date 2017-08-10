<?php
namespace m2i\project\Model\Entity;

class TrainingSessionDTO {

    private static $columnMap = [
       'id' => 'id', 
'start_date' => 'startDate', 
'end_date' => 'endDate', 
'training_program_id' => 'trainingProgramId', 
'session_code' => 'sessionCode'
    ];

    private $id;
private $startDate;
private $endDate;
private $trainingProgramId;
private $sessionCode;

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



    public function setId($id){
            $this->id = $id;
            return $this;
        }
public function getId(){
            return $this->id;
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
public function setTrainingProgramId($trainingProgramId){
            $this->trainingProgramId = $trainingProgramId;
            return $this;
        }
public function getTrainingProgramId(){
            return $this->trainingProgramId;
        }
public function setSessionCode($sessionCode){
            $this->sessionCode = $sessionCode;
            return $this;
        }
public function getSessionCode(){
            return $this->sessionCode;
        }



}