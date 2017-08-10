<?php
namespace m2i\project\Model\Entity;

class PersonDTO {

    private static $columnMap = [
       'id' => 'id', 
'first_name' => 'firstName', 
'name' => 'name', 
'birth_date' => 'birthDate'
    ];

    private $id;
private $firstName;
private $name;
private $birthDate;

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
public function setFirstName($firstName){
            $this->firstName = $firstName;
            return $this;
        }
public function getFirstName(){
            return $this->firstName;
        }
public function setName($name){
            $this->name = $name;
            return $this;
        }
public function getName(){
            return $this->name;
        }
public function setBirthDate($birthDate){
            $this->birthDate = $birthDate;
            return $this;
        }
public function getBirthDate(){
            return $this->birthDate;
        }



}