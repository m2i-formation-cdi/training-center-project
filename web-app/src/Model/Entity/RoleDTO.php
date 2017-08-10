<?php
namespace m2i\project\Model\Entity;

class RoleDTO {

    private static $columnMap = [
       'id' => 'id', 
'role_name' => 'roleName'
    ];

    private $id;
private $roleName;

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
public function setRoleName($roleName){
            $this->roleName = $roleName;
            return $this;
        }
public function getRoleName(){
            return $this->roleName;
        }



}