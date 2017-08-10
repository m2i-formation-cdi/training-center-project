<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingProgramDTO;

interface ITrainingProgramDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(TrainingProgramDTO $trainingProgram);

    public function save (TrainingProgramDTO $trainingProgram);

}