<?php
namespace m2i\project\Model\Entity;

class TrainingSessionEnrollmentDTO {

    private static $columnMap = [
       'session_id' => 'sessionId', 
'person_id' => 'personId', 
'degree_id' => 'degreeId'
    ];

    private $sessionId;
private $personId;
private $degreeId;

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
public function setId($personId){
            $this->personId = $personId;
            return $this;
        }
public function getId(){
            return $this->personId;
        }
public function setDegreeId($degreeId){
            $this->degreeId = $degreeId;
            return $this;
        }
public function getDegreeId(){
            return $this->degreeId;
        }



}