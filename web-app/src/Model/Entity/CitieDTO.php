<?php
namespace m2i\project\Model\Entity;

class CitieDTO {

    private static $columnMap = [
       'id' => 'id', 
'insee_code' => 'inseeCode', 
'postal_code' => 'postalCode', 
'city_name' => 'cityName'
    ];

    private $id;
private $inseeCode;
private $postalCode;
private $cityName;

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
public function setInseeCode($inseeCode){
            $this->inseeCode = $inseeCode;
            return $this;
        }
public function getInseeCode(){
            return $this->inseeCode;
        }
public function setPostalCode($postalCode){
            $this->postalCode = $postalCode;
            return $this;
        }
public function getPostalCode(){
            return $this->postalCode;
        }
public function setCityName($cityName){
            $this->cityName = $cityName;
            return $this;
        }
public function getCityName(){
            return $this->cityName;
        }



}