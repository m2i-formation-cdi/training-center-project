<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\RoleDTO;

interface IRoleDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(RoleDTO $role);

    public function save (RoleDTO $role);

}