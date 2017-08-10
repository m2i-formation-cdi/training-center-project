<?php
namespace m2i\project\Model\Entity;

class DegreeLevelDTO {

    private static $columnMap = [
       'id' => 'id', 
'french_level' => 'frenchLevel', 
'european_level' => 'europeanLevel', 
'level_label' => 'levelLabel'
    ];

    private $id;
private $frenchLevel;
private $europeanLevel;
private $levelLabel;

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
public function setFrenchLevel($frenchLevel){
            $this->frenchLevel = $frenchLevel;
            return $this;
        }
public function getFrenchLevel(){
            return $this->frenchLevel;
        }
public function setEuropeanLevel($europeanLevel){
            $this->europeanLevel = $europeanLevel;
            return $this;
        }
public function getEuropeanLevel(){
            return $this->europeanLevel;
        }
public function setLevelLabel($levelLabel){
            $this->levelLabel = $levelLabel;
            return $this;
        }
public function getLevelLabel(){
            return $this->levelLabel;
        }



}