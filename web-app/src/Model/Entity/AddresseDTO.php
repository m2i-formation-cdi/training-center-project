<?php
namespace m2i\project\Model\Entity;

class AddresseDTO {

    private static $columnMap = [
       'id' => 'id', 
'person_id' => 'personId', 
'address_line1' => 'addressLine1', 
'address_line2' => 'addressLine2', 
'address_line3' => 'addressLine3', 
'city_id' => 'cityId'
    ];

    private $id;
private $personId;
private $addressLine1;
private $addressLine2;
private $addressLine3;
private $cityId;

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
public function setPersonId($personId){
            $this->personId = $personId;
            return $this;
        }
public function getPersonId(){
            return $this->personId;
        }
public function setAddressLine1($addressLine1){
            $this->addressLine1 = $addressLine1;
            return $this;
        }
public function getAddressLine1(){
            return $this->addressLine1;
        }
public function setAddressLine2($addressLine2){
            $this->addressLine2 = $addressLine2;
            return $this;
        }
public function getAddressLine2(){
            return $this->addressLine2;
        }
public function setAddressLine3($addressLine3){
            $this->addressLine3 = $addressLine3;
            return $this;
        }
public function getAddressLine3(){
            return $this->addressLine3;
        }
public function setCityId($cityId){
            $this->cityId = $cityId;
            return $this;
        }
public function getCityId(){
            return $this->cityId;
        }



}