<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingProgramDTO;

class TrainingProgramDAO implements ITrainingProgramDAO {

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
        $sql = "SELECT * FROM training_programs";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM training_programs WHERE id=? ";
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
        $sql = "SELECT * FROM training_programs ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingProgramDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return TrainingProgramDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingProgramDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param TrainingProgramDTO $trainingProgram
    */
    public function save(TrainingProgramDTO $trainingProgram){
        if($trainingProgram->getId() == null){
            $pk = $this->insert($trainingProgram);
            $trainingProgram->setId($pk);
        } else {
            $this->update($trainingProgram);
        }
    }

    /**
    * @param TrainingProgramDTO $trainingProgram
    * @return int
    */
    private function insert(TrainingProgramDTO $trainingProgram){
        $sql = "INSERT INTO training_programs (label, description) VALUES ( ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $trainingProgram->getLabel(), $trainingProgram->getDescription()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param TrainingProgramDTO $trainingProgram
    */
    private function update(TrainingProgramDTO $trainingProgram){
        $sql = "UPDATE training_programs SET label=? , description=?  WHERE id=? ";
        $data = array(
            $trainingProgram->getLabel(),
$trainingProgram->getDescription(),
$trainingProgram->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $trainingProgram->getLabel(),
$trainingProgram->getDescription(),
$trainingProgram->getId()

        ]);

    }

    /**
    * @param TrainingProgramDTO $trainingProgram
    * @return bool
    */
    public function delete(TrainingProgramDTO $trainingProgram){
        if($trainingProgram->getId() != null){
            $sql = "DELETE FROM training_programs WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$trainingProgram->getId()]);
        }
    }

}