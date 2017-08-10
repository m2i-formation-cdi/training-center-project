<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\UserDTO;

class UserDAO implements IUserDAO {

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
        $sql = "SELECT * FROM users";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM users WHERE id=? ";
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
        $sql = "SELECT * FROM users ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, UserDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return UserDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, UserDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param UserDTO $user
    */
    public function save(UserDTO $user){
        if($user->getId() == null){
            $pk = $this->insert($user);
            $user->setId($pk);
        } else {
            $this->update($user);
        }
    }

    /**
    * @param UserDTO $user
    * @return int
    */
    private function insert(UserDTO $user){
        $sql = "INSERT INTO users (email, password, crated_at, updated_at, person_id) VALUES ( ?, ?, ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $user->getEmail(), $user->getPassword(), $user->getCratedAt(), $user->getUpdatedAt(), $user->getPersonId()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param UserDTO $user
    */
    private function update(UserDTO $user){
        $sql = "UPDATE users SET email=? , password=? , crated_at=? , updated_at=? , person_id=?  WHERE id=? ";
        $data = array(
            $user->getEmail(),
$user->getPassword(),
$user->getCratedAt(),
$user->getUpdatedAt(),
$user->getPersonId(),
$user->getId()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $user->getEmail(),
$user->getPassword(),
$user->getCratedAt(),
$user->getUpdatedAt(),
$user->getPersonId(),
$user->getId()

        ]);

    }

    /**
    * @param UserDTO $user
    * @return bool
    */
    public function delete(UserDTO $user){
        if($user->getId() != null){
            $sql = "DELETE FROM users WHERE id=? ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([$user->getId()]);
        }
    }

}