<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\ClassroomDTO;

interface IClassroomDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(ClassroomDTO $classroom);

    public function save (ClassroomDTO $classroom);

}