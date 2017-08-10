<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\PersonDTO;

interface IPersonDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(PersonDTO $person);

    public function save (PersonDTO $person);

}