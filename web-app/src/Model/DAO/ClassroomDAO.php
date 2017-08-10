<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\ClassroomDTO;

class ClassroomDAO implements IClassroomDAO {

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
        $sql = "SELECT * FROM classrooms";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM classrooms WHERE id=? ";
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
        $sql = "SELECT * FROM classrooms ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, ClassroomDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return ClassroomDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, ClassroomDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param ClassroomDTO $classroom
    */
    public function save(ClassroomDTO $classroom){
        if($classroom->getId() == null){
            $pk = $this->insert($classroom);
            $classroom->setId($pk);
        } else {
            $this->update($classroom);
        }
    }

    /**
    * @param ClassroomDTO $classroom
    * @return int
    */
    private function insert(ClassroomDTO $classroom){
        $sql = "INSERT INTO classrooms (classroom_name, classroom_capacity) VALUES ( ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $classroom->getClassroomName(), $classroom->getClassroomCapacity()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param ClassroomDTO $classroom
    */
    private function update(ClassroomDTO $classroom){
        $sql = "UPDATE classrooms SET classroom_name=? , classroom_capacity=?  WHERE id=? ";
        $data = array(
            $classroom->getClassroomName(),
$classroom->getClassroomCapacity(),
$classroom->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $classroom->getClassroomName(),
$classroom->getClassroomCapacity(),
$classroom->getId()

        ]);

    }

    /**
    * @param ClassroomDTO $classroom
    * @return bool
    */
    public function delete(ClassroomDTO $classroom){
        if($classroom->getId() != null){
            $sql = "DELETE FROM classrooms WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$classroom->getId()]);
        }
    }

}