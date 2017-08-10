<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingProgramsCourseDTO;

class TrainingProgramsCourseDAO implements ITrainingProgramsCourseDAO {

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
        $sql = "SELECT * FROM training_programs_courses";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM training_programs_courses WHERE program_id=?  AND course_id=?  AND order=? ";
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
        $sql = "SELECT * FROM training_programs_courses ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingProgramsCourseDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return TrainingProgramsCourseDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainingProgramsCourseDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param TrainingProgramsCourseDTO $trainingProgramsCourse
    */
    public function save(TrainingProgramsCourseDTO $trainingProgramsCourse){
        if($trainingProgramsCourse->getId() == null){
            $pk = $this->insert($trainingProgramsCourse);
            $trainingProgramsCourse->setId($pk);
        } else {
            $this->update($trainingProgramsCourse);
        }
    }

    /**
    * @param TrainingProgramsCourseDTO $trainingProgramsCourse
    * @return int
    */
    private function insert(TrainingProgramsCourseDTO $trainingProgramsCourse){
        $sql = "INSERT INTO training_programs_courses (program_id, course_id, order) VALUES ( ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $trainingProgramsCourse->getId(), $trainingProgramsCourse->getId(), $trainingProgramsCourse->getId()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param TrainingProgramsCourseDTO $trainingProgramsCourse
    */
    private function update(TrainingProgramsCourseDTO $trainingProgramsCourse){
        $sql = "UPDATE training_programs_courses SET program_id=? , course_id=? , order=?  WHERE program_id=?  AND course_id=?  AND order=? ";
        $data = array(
            $trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId(),
$trainingProgramsCourse->getId()

        ]);

    }

    /**
    * @param TrainingProgramsCourseDTO $trainingProgramsCourse
    * @return bool
    */
    public function delete(TrainingProgramsCourseDTO $trainingProgramsCourse){
        if($trainingProgramsCourse->getId() != null){
            $sql = "DELETE FROM training_programs_courses WHERE program_id=?  AND course_id=?  AND order=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$trainingProgramsCourse->getId(), 
$trainingProgramsCourse->getId(), 
$trainingProgramsCourse->getId()]);
        }
    }

}