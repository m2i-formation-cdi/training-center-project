<?php
namespace m2i\project\Model\Entity;

class DegreeDTO {

    private static $columnMap = [
       'id' => 'id', 
'degree_label' => 'degreeLabel', 
'degree_description' => 'degreeDescription', 
'degree_level_id' => 'degreeLevelId'
    ];

    private $id;
private $degreeLabel;
private $degreeDescription;
private $degreeLevelId;

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
public function setDegreeLabel($degreeLabel){
            $this->degreeLabel = $degreeLabel;
            return $this;
        }
public function getDegreeLabel(){
            return $this->degreeLabel;
        }
public function setDegreeDescription($degreeDescription){
            $this->degreeDescription = $degreeDescription;
            return $this;
        }
public function getDegreeDescription(){
            return $this->degreeDescription;
        }
public function setDegreeLevelId($degreeLevelId){
            $this->degreeLevelId = $degreeLevelId;
            return $this;
        }
public function getDegreeLevelId(){
            return $this->degreeLevelId;
        }



}