<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainerDTO;

interface ITrainerDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(TrainerDTO $trainer);

    public function save (TrainerDTO $trainer);

}