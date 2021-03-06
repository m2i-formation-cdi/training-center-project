<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\CitieDTO;

class CitieDAO implements ICitieDAO {

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
        $sql = "SELECT * FROM cities";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM cities WHERE id=? ";
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
        $sql = "SELECT * FROM cities ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, CitieDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return CitieDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, CitieDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param CitieDTO $citie
    */
    public function save(CitieDTO $citie){
        if($citie->getId() == null){
            $pk = $this->insert($citie);
            $citie->setId($pk);
        } else {
            $this->update($citie);
        }
    }

    /**
    * @param CitieDTO $citie
    * @return int
    */
    private function insert(CitieDTO $citie){
        $sql = "INSERT INTO cities (insee_code, postal_code, city_name) VALUES ( ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $citie->getInseeCode(), $citie->getPostalCode(), $citie->getCityName()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param CitieDTO $citie
    */
    private function update(CitieDTO $citie){
        $sql = "UPDATE cities SET insee_code=? , postal_code=? , city_name=?  WHERE id=? ";
        $data = array(
            $citie->getInseeCode(),
$citie->getPostalCode(),
$citie->getCityName(),
$citie->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $citie->getInseeCode(),
$citie->getPostalCode(),
$citie->getCityName(),
$citie->getId()

        ]);

    }

    /**
    * @param CitieDTO $citie
    * @return bool
    */
    public function delete(CitieDTO $citie){
        if($citie->getId() != null){
            $sql = "DELETE FROM cities WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$citie->getId()]);
        }
    }

}