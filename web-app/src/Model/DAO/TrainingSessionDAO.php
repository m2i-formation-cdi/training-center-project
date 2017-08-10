<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingSessionDTO;

class TrainingSessionDAO implements ITrainingSessionDAO {

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
        $sql = "SELECT * FROM training_sessions";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM training_sessions WHERE id=? ";
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
        $sql = "SELECT * FROM training_sessions ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingSessionDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return TrainingSessionDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingSessionDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param TrainingSessionDTO $trainingSession
    */
    public function save(TrainingSessionDTO $trainingSession){
        if($trainingSession->getId() == null){
            $pk = $this->insert($trainingSession);
            $trainingSession->setId($pk);
        } else {
            $this->update($trainingSession);
        }
    }

    /**
    * @param TrainingSessionDTO $trainingSession
    * @return int
    */
    private function insert(TrainingSessionDTO $trainingSession){
        $sql = "INSERT INTO training_sessions (start_date, end_date, training_program_id, session_code) VALUES ( ?, ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $trainingSession->getStartDate(), $trainingSession->getEndDate(), $trainingSession->getTrainingProgramId(), $trainingSession->getSessionCode()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param TrainingSessionDTO $trainingSession
    */
    private function update(TrainingSessionDTO $trainingSession){
        $sql = "UPDATE training_sessions SET start_date=? , end_date=? , training_program_id=? , session_code=?  WHERE id=? ";
        $data = array(
            $trainingSession->getStartDate(),
$trainingSession->getEndDate(),
$trainingSession->getTrainingProgramId(),
$trainingSession->getSessionCode(),
$trainingSession->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $trainingSession->getStartDate(),
$trainingSession->getEndDate(),
$trainingSession->getTrainingProgramId(),
$trainingSession->getSessionCode(),
$trainingSession->getId()

        ]);

    }

    /**
    * @param TrainingSessionDTO $trainingSession
    * @return bool
    */
    public function delete(TrainingSessionDTO $trainingSession){
        if($trainingSession->getId() != null){
            $sql = "DELETE FROM training_sessions WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$trainingSession->getId()]);
        }
    }

}