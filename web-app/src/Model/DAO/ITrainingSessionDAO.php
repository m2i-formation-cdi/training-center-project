<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingSessionDTO;

interface ITrainingSessionDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(TrainingSessionDTO $trainingSession);

    public function save (TrainingSessionDTO $trainingSession);

}