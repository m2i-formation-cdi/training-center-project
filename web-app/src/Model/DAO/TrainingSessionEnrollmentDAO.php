<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingSessionEnrollmentDTO;

class TrainingSessionEnrollmentDAO implements ITrainingSessionEnrollmentDAO {

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
        $sql = "SELECT * FROM training_session_enrollment";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM training_session_enrollment WHERE session_id=?  AND person_id=? ";
        $statement = $this->pdo->prepare($sql);
        $statement->execute($pk);
        $this->selectStatement = $statement;
        return $this;
    }

    public function findPersonsBySession(array $pk)
    {
        $sql = 'SELECT tse.session_id AS session_id, p.id AS person_id, p.first_name AS person_firstname, p.name AS person_name, p.birth_date AS person_birthdate ' .
               'FROM training_session_enrollment AS tse ' .
               'INNER JOIN persons AS p ' .
               'ON p.id = tse.person_id ' .
               'WHERE tse.session_id = ?'
        ;
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
        $sql = "SELECT * FROM training_session_enrollment ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingSessionEnrollmentDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return TrainingSessionEnrollmentDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingSessionEnrollmentDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param TrainingSessionEnrollmentDTO $trainingSessionEnrollment
    */
    public function save(TrainingSessionEnrollmentDTO $trainingSessionEnrollment){
        if($trainingSessionEnrollment->getId() == null){
            $pk = $this->insert($trainingSessionEnrollment);
            $trainingSessionEnrollment->setId($pk);
        } else {
            $this->update($trainingSessionEnrollment);
        }
    }

    /**
    * @param TrainingSessionEnrollmentDTO $trainingSessionEnrollment
    * @return int
    */
    private function insert(TrainingSessionEnrollmentDTO $trainingSessionEnrollment){
        $sql = "INSERT INTO training_session_enrollment (session_id, person_id, degree_id) VALUES ( ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $trainingSessionEnrollment->getId(), $trainingSessionEnrollment->getId(), $trainingSessionEnrollment->getDegreeId()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param TrainingSessionEnrollmentDTO $trainingSessionEnrollment
    */
    private function update(TrainingSessionEnrollmentDTO $trainingSessionEnrollment){
        $sql = "UPDATE training_session_enrollment SET session_id=? , person_id=? , degree_id=?  WHERE session_id=?  AND person_id=? ";
        $data = array(
            $trainingSessionEnrollment->getId(),
$trainingSessionEnrollment->getId(),
$trainingSessionEnrollment->getDegreeId(),
$trainingSessionEnrollment->getId(),
$trainingSessionEnrollment->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $trainingSessionEnrollment->getId(),
$trainingSessionEnrollment->getId(),
$trainingSessionEnrollment->getDegreeId(),
$trainingSessionEnrollment->getId(),
$trainingSessionEnrollment->getId()

        ]);

    }

    /**
    * @param TrainingSessionEnrollmentDTO $trainingSessionEnrollment
    * @return bool
    */
    public function delete(TrainingSessionEnrollmentDTO $trainingSessionEnrollment){
        if($trainingSessionEnrollment->getId() != null){
            $sql = "DELETE FROM training_session_enrollment WHERE session_id=?  AND person_id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$trainingSessionEnrollment->getId(), 
$trainingSessionEnrollment->getId()]);
        }
    }

}