<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\CoursesSkillDTO;

interface ICoursesSkillDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(CoursesSkillDTO $coursesSkill);

    public function save (CoursesSkillDTO $coursesSkill);

}