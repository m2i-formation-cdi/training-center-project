<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\SkillDTO;

class SkillDAO implements ISkillDAO {

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
        $sql = "SELECT * FROM skills";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM skills WHERE id=? ";
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
        $sql = "SELECT * FROM skills ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, SkillDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return SkillDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, SkillDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param SkillDTO $skill
    */
    public function save(SkillDTO $skill){
        if($skill->getId() == null){
            $pk = $this->insert($skill);
            $skill->setId($pk);
        } else {
            $this->update($skill);
        }
    }

    /**
    * @param SkillDTO $skill
    * @return int
    */
    private function insert(SkillDTO $skill){
        $sql = "INSERT INTO skills (skillName) VALUES ( ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $skill->getSkillName()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param SkillDTO $skill
    */
    private function update(SkillDTO $skill){
        $sql = "UPDATE skills SET skillName=?  WHERE id=? ";
        $data = array(
            $skill->getSkillName(),
$skill->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $skill->getSkillName(),
$skill->getId()

        ]);

    }

    /**
    * @param SkillDTO $skill
    * @return bool
    */
    public function delete(SkillDTO $skill){
        if($skill->getId() != null){
            $sql = "DELETE FROM skills WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$skill->getId()]);
        }
    }

}