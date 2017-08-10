<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\CourseDTO;

interface ICourseDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(CourseDTO $course);

    public function save (CourseDTO $course);

}