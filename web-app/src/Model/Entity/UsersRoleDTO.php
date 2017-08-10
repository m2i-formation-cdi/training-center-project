<?php
namespace m2i\project\Model\Entity;

class UsersRoleDTO {

    private static $columnMap = [
       'user_id' => 'userId', 
'role_id' => 'roleId', 
'date_granted' => 'dateGranted', 
'date_revoked' => 'dateRevoked'
    ];

    private $userId;
private $roleId;
private $dateGranted;
private $dateRevoked;

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



    public function setUserId($userId){
            $this->userId = $userId;
            return $this;
        }
public function getUserId(){
            return $this->userId;
        }
public function setRoleId($roleId){
            $this->roleId = $roleId;
            return $this;
        }
public function getRoleId(){
            return $this->roleId;
        }
public function setDateGranted($dateGranted){
            $this->dateGranted = $dateGranted;
            return $this;
        }
public function getDateGranted(){
            return $this->dateGranted;
        }
public function setDateRevoked($dateRevoked){
            $this->dateRevoked = $dateRevoked;
            return $this;
        }
public function getDateRevoked(){
            return $this->dateRevoked;
        }



}