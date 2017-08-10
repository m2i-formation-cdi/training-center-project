<?php
namespace m2i\project\Model\Entity;

class TrainingProgramDTO {

    private static $columnMap = [
       'id' => 'id', 
'label' => 'label', 
'description' => 'description'
    ];

    private $id;
private $label;
private $description;

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
public function setLabel($label){
            $this->label = $label;
            return $this;
        }
public function getLabel(){
            return $this->label;
        }
public function setDescription($description){
            $this->description = $description;
            return $this;
        }
public function getDescription(){
            return $this->description;
        }



}