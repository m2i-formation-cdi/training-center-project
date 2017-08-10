<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\DegreeLevelDTO;

class DegreeLevelDAO implements IDegreeLevelDAO {

    /**
    * @var \PDO
    */
    private $pdo;

    /**
     * @var \PDOStatement;
     */
    private $selectStatement;


    /**
    * DAOClient constructor.
    * @param \PDO $pdo
    */
    public function __construct(\PDO $pdo)
    {
    $this->pdo = $pdo;
    }

    /**
    * @return $this
    */
    public function findAll(){
        $sql = "SELECT * FROM degree_level";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM degree_level WHERE id=? ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($pk);
        $this->selectStatement = $statement;
        return $this;
    }

    /**
    * @param array $search
    * @return $this
    */
    public function find(array $search = [], array $orderBy = [], array $limit = []){
        $sql = "SELECT * FROM degree_level ";

        if(count($search)>0){
            $sql .= " WHERE ";
            $cols = array_map(
                function($item){
                    return "$item=:$item";
                }, array_keys($search)
            );

            $sql .= implode(" AND ", $cols);
        }

        if(count($orderBy)>0){
            $sql .= "ORDER BY ";
            $cols = array_map(
                function($item) use($orderBy){
                    return "$item ". $orderBy[$item];
                },
                array_keys($orderBy)
            );
            $sql .= implode(", ", $cols);
        }

        if(count($limit) >0){
            $sql .= " LIMIT ".$limit[0];
            if(isset($limit[1])){
                $sql .= " OFFSET ". $limit[1];
            }
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($search);
        $this->selectStatement = $statement;
        return $this;
    }


    /**
    * @return array
    */
    public function getAllAsArray(){
        return $this->selectStatement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
    * @return array
    */
    public function getAllAsArrayGroupedById(){
        $data =  $this->selectStatement->fetchAll(\PDO::FETCH_ASSOC|\PDO::FETCH_GROUP);

        $data = array_map(
            function ($item){
                return $item[0];
            }
            , $data
        );
        
        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
        
    }

    /**
    * @return array
    */
    public function getOneAsArray(){
        $data = $this->selectStatement->fetch(\PDO::FETCH_ASSOC);

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return array
    */
    public function getAllAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, DegreeLevelDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return DegreeLevelDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, DegreeLevelDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param DegreeLevelDTO $degreeLevel
    */
    public function save(DegreeLevelDTO $degreeLevel){
        if($degreeLevel->getId() == null){
            $pk = $this->insert($degreeLevel);
            $degreeLevel->setId($pk);
        } else {
            $this->update($degreeLevel);
        }
    }

    /**
    * @param DegreeLevelDTO $degreeLevel
    * @return int
    */
    private function insert(DegreeLevelDTO $degreeLevel){
        $sql = "INSERT INTO degree_level (french_level, european_level, level_label) VALUES ( ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $degreeLevel->getFrenchLevel(), $degreeLevel->getEuropeanLevel(), $degreeLevel->getLevelLabel()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param DegreeLevelDTO $degreeLevel
    */
    private function update(DegreeLevelDTO $degreeLevel){
        $sql = "UPDATE degree_level SET french_level=? , european_level=? , level_label=?  WHERE id=? ";
        $data = array(
            $degreeLevel->getFrenchLevel(),
$degreeLevel->getEuropeanLevel(),
$degreeLevel->getLevelLabel(),
$degreeLevel->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $degreeLevel->getFrenchLevel(),
$degreeLevel->getEuropeanLevel(),
$degreeLevel->getLevelLabel(),
$degreeLevel->getId()

        ]);

    }

    /**
    * @param DegreeLevelDTO $degreeLevel
    * @return bool
    */
    public function delete(DegreeLevelDTO $degreeLevel){
        if($degreeLevel->getId() != null){
            $sql = "DELETE FROM degree_level WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$degreeLevel->getId()]);
        }
    }

}