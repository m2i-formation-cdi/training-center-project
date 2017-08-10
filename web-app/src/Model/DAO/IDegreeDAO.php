<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\DegreeDTO;

interface IDegreeDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(DegreeDTO $degree);

    public function save (DegreeDTO $degree);

}