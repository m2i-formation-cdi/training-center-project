<?php
namespace m2i\project\Model\Entity;

class ClassroomDTO {

    private static $columnMap = [
       'id' => 'id', 
'classroom_name' => 'classroomName', 
'classroom_capacity' => 'classroomCapacity'
    ];

    private $id;
private $classroomName;
private $classroomCapacity;

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
public function setClassroomName($classroomName){
            $this->classroomName = $classroomName;
            return $this;
        }
public function getClassroomName(){
            return $this->classroomName;
        }
public function setClassroomCapacity($classroomCapacity){
            $this->classroomCapacity = $classroomCapacity;
            return $this;
        }
public function getClassroomCapacity(){
            return $this->classroomCapacity;
        }



}