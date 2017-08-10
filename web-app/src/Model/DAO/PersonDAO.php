<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\PersonDTO;

class PersonDAO implements IPersonDAO {

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
        $sql = "SELECT * FROM persons";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM persons WHERE id=? ";
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
        $sql = "SELECT * FROM persons ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, PersonDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return PersonDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, PersonDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param PersonDTO $person
    */
    public function save(PersonDTO $person){
        if($person->getId() == null){
            $pk = $this->insert($person);
            $person->setId($pk);
        } else {
            $this->update($person);
        }
    }

    /**
    * @param PersonDTO $person
    * @return int
    */
    private function insert(PersonDTO $person){
        $sql = "INSERT INTO persons (first_name, name, birth_date) VALUES ( ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $person->getFirstName(), $person->getName(), $person->getBirthDate()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param PersonDTO $person
    */
    private function update(PersonDTO $person){
        $sql = "UPDATE persons SET first_name=? , name=? , birth_date=?  WHERE id=? ";
        $data = array(
            $person->getFirstName(),
$person->getName(),
$person->getBirthDate(),
$person->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $person->getFirstName(),
$person->getName(),
$person->getBirthDate(),
$person->getId()

        ]);

    }

    /**
    * @param PersonDTO $person
    * @return bool
    */
    public function delete(PersonDTO $person){
        if($person->getId() != null){
            $sql = "DELETE FROM persons WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$person->getId()]);
        }
    }

}