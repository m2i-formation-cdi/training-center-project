<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\AddresseDTO;

class AddresseDAO implements IAddresseDAO {

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
        $sql = "SELECT * FROM addresses";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM addresses WHERE id=? ";
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
        $sql = "SELECT * FROM addresses ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, AddresseDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return AddresseDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, AddresseDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param AddresseDTO $addresse
    */
    public function save(AddresseDTO $addresse){
        if($addresse->getId() == null){
            $pk = $this->insert($addresse);
            $addresse->setId($pk);
        } else {
            $this->update($addresse);
        }
    }

    /**
    * @param AddresseDTO $addresse
    * @return int
    */
    private function insert(AddresseDTO $addresse){
        $sql = "INSERT INTO addresses (person_id, address_line1, address_line2, address_line3, city_id) VALUES ( ?, ?, ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $addresse->getPersonId(), $addresse->getAddressLine1(), $addresse->getAddressLine2(), $addresse->getAddressLine3(), $addresse->getCityId()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param AddresseDTO $addresse
    */
    private function update(AddresseDTO $addresse){
        $sql = "UPDATE addresses SET person_id=? , address_line1=? , address_line2=? , address_line3=? , city_id=?  WHERE id=? ";
        $data = array(
            $addresse->getPersonId(),
$addresse->getAddressLine1(),
$addresse->getAddressLine2(),
$addresse->getAddressLine3(),
$addresse->getCityId(),
$addresse->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $addresse->getPersonId(),
$addresse->getAddressLine1(),
$addresse->getAddressLine2(),
$addresse->getAddressLine3(),
$addresse->getCityId(),
$addresse->getId()

        ]);

    }

    /**
    * @param AddresseDTO $addresse
    * @return bool
    */
    public function delete(AddresseDTO $addresse){
        if($addresse->getId() != null){
            $sql = "DELETE FROM addresses WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$addresse->getId()]);
        }
    }

}