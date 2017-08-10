<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\TrainingSessionEnrollmentDTO;

interface ITrainingSessionEnrollmentDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(TrainingSessionEnrollmentDTO $trainingSessionEnrollment);

    public function save (TrainingSessionEnrollmentDTO $trainingSessionEnrollment);

}