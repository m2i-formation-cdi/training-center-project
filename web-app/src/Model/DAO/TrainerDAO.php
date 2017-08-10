<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainerDTO;

class TrainerDAO implements ITrainerDAO {

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
        $sql = "SELECT * FROM trainers";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM trainers WHERE id=? ";
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
        $sql = "SELECT * FROM trainers ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainerDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return TrainerDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, TrainerDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param TrainerDTO $trainer
    */
    public function save(TrainerDTO $trainer){
        if($trainer->getId() == null){
            $pk = $this->insert($trainer);
            $trainer->setId($pk);
        } else {
            $this->update($trainer);
        }
    }

    /**
    * @param TrainerDTO $trainer
    * @return int
    */
    private function insert(TrainerDTO $trainer){
        $sql = "INSERT INTO trainers (person_id, trainer_daily_fee) VALUES ( ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $trainer->getPersonId(), $trainer->getTrainerDailyFee()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param TrainerDTO $trainer
    */
    private function update(TrainerDTO $trainer){
        $sql = "UPDATE trainers SET person_id=? , trainer_daily_fee=?  WHERE id=? ";
        $data = array(
            $trainer->getPersonId(),
$trainer->getTrainerDailyFee(),
$trainer->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $trainer->getPersonId(),
$trainer->getTrainerDailyFee(),
$trainer->getId()

        ]);

    }

    /**
    * @param TrainerDTO $trainer
    * @return bool
    */
    public function delete(TrainerDTO $trainer){
        if($trainer->getId() != null){
            $sql = "DELETE FROM trainers WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$trainer->getId()]);
        }
    }

}