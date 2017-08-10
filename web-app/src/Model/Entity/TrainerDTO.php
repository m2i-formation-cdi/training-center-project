<?php
namespace m2i\project\Model\Entity;

class TrainerDTO {

    private static $columnMap = [
       'id' => 'id', 
'person_id' => 'personId', 
'trainer_daily_fee' => 'trainerDailyFee'
    ];

    private $id;
private $personId;
private $trainerDailyFee;

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
public function setPersonId($personId){
            $this->personId = $personId;
            return $this;
        }
public function getPersonId(){
            return $this->personId;
        }
public function setTrainerDailyFee($trainerDailyFee){
            $this->trainerDailyFee = $trainerDailyFee;
            return $this;
        }
public function getTrainerDailyFee(){
            return $this->trainerDailyFee;
        }



}