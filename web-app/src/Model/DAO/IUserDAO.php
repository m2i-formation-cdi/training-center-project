<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\UserDTO;

interface IUserDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(UserDTO $user);

    public function save (UserDTO $user);

}