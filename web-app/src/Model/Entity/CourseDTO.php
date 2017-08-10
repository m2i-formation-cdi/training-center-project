<?php
namespace m2i\project\Model\Entity;

class CourseDTO {

    private static $columnMap = [
       'id' => 'id', 
'course_label' => 'courseLabel', 
'course_description' => 'courseDescription'
    ];

    private $id;
private $courseLabel;
private $courseDescription;

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
public function setCourseLabel($courseLabel){
            $this->courseLabel = $courseLabel;
            return $this;
        }
public function getCourseLabel(){
            return $this->courseLabel;
        }
public function setCourseDescription($courseDescription){
            $this->courseDescription = $courseDescription;
            return $this;
        }
public function getCourseDescription(){
            return $this->courseDescription;
        }



}