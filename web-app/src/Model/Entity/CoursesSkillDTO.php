<?php
namespace m2i\project\Model\Entity;

class CoursesSkillDTO {

    private static $columnMap = [
       'course_id' => 'courseId', 
'skill_id' => 'skillId'
    ];

    private $courseId;
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



    public function setId($courseId){
            $this->courseId = $courseId;
            return $this;
        }
public function getId(){
            return $this->courseId;
        }
public function setId($skillId){
            $this->skillId = $skillId;
            return $this;
        }
public function getId(){
            return $this->skillId;
        }



}