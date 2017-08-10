<?php
namespace m2i\project\Model\Entity;

class UserDTO {

    private static $columnMap = [
       'id' => 'id', 
'email' => 'email', 
'password' => 'password', 
'crated_at' => 'cratedAt', 
'updated_at' => 'updatedAt', 
'person_id' => 'personId'
    ];

    private $id;
private $email;
private $password;
private $cratedAt;
private $updatedAt;
private $personId;

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
public function setEmail($email){
            $this->email = $email;
            return $this;
        }
public function getEmail(){
            return $this->email;
        }
public function setPassword($password){
            $this->password = $password;
            return $this;
        }
public function getPassword(){
            return $this->password;
        }
public function setCratedAt($cratedAt){
            $this->cratedAt = $cratedAt;
            return $this;
        }
public function getCratedAt(){
            return $this->cratedAt;
        }
public function setUpdatedAt($updatedAt){
            $this->updatedAt = $updatedAt;
            return $this;
        }
public function getUpdatedAt(){
            return $this->updatedAt;
        }
public function setPersonId($personId){
            $this->personId = $personId;
            return $this;
        }
public function getPersonId(){
            return $this->personId;
        }



}