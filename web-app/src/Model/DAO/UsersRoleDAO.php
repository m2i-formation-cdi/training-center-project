<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\UsersRoleDTO;

class UsersRoleDAO implements IUsersRoleDAO {

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
        $sql = "SELECT * FROM users_roles";
        $this->selectStatement = $this->pdo->query($sql);
        return $this;
    }

    /**
    * @param array $pk
    * @return $this
    */
    public function findOneById(array $pk){
        $sql = "SELECT * FROM users_roles WHERE ";
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
        $sql = "SELECT * FROM users_roles ";

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
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, UsersRoleDTO::class);
        $data = $this->selectStatement->fetchAll();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @return UsersRoleDTO
    */
    public function getOneAsEntity(){
        $this->selectStatement->setFetchMode(\PDO::FETCH_CLASS, UsersRoleDTO::class);
        $data = $this->selectStatement->fetch();

        if($data){
            return $data;
        } else {
            throw new Exception("Ancun résultat pour cette requête");
        }
    }

    /**
    * @param UsersRoleDTO $usersRole
    */
    public function save(UsersRoleDTO $usersRole){
        if($usersRole->getId() == null){
            $pk = $this->insert($usersRole);
            $usersRole->setId($pk);
        } else {
            $this->update($usersRole);
        }
    }

    /**
    * @param UsersRoleDTO $usersRole
    * @return int
    */
    private function insert(UsersRoleDTO $usersRole){
        $sql = "INSERT INTO users_roles (user_id, role_id, date_granted, date_revoked) VALUES ( ?, ?, ?, ? )";
        $statement = $this->pdo->prepare($sql);
        $statement->execute([
            $usersRole->getUserId(), $usersRole->getRoleId(), $usersRole->getDateGranted(), $usersRole->getDateRevoked()
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
    * @param UsersRoleDTO $usersRole
    */
    private function update(UsersRoleDTO $usersRole){
        $sql = "UPDATE users_roles SET user_id=? , role_id=? , date_granted=? , date_revoked=?  WHERE ";
        $data = array(
            $usersRole->getUserId(),
$usersRole->getRoleId(),
$usersRole->getDateGranted(),
$usersRole->getDateRevoked()
        );
        $statement = $this->pdo->prepare($sql);

        $statement->execute([
            $usersRole->getUserId(),
$usersRole->getRoleId(),
$usersRole->getDateGranted(),
$usersRole->getDateRevoked()

        ]);

    }

    /**
    * @param UsersRoleDTO $usersRole
    * @return bool
    */
    public function delete(UsersRoleDTO $usersRole){
        if($usersRole->getId() != null){
            $sql = "DELETE FROM users_roles WHERE ";
            $statement = $this->pdo->prepare($sql);
            return $statement->execute([]);
        }
    }

}