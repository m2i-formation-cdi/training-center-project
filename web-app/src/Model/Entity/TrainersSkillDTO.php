<?php
namespace m2i\project\Model\Entity;

class TrainersSkillDTO {

    private static $columnMap = [
       'trainer_id' => 'trainerId', 
'skill_id' => 'skillId'
    ];

    private $trainerId;
private $skillId;

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



    public function setId($trainerId){
            $this->trainerId = $trainerId;
            return $this;
        }
public function getId(){
            return $this->trainerId;
        }
public function setId($skillId){
            $this->skillId = $skillId;
            return $this;
        }
public function getId(){
            return $this->skillId;
        }



}