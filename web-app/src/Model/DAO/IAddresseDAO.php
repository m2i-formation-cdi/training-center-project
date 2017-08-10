<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\AddresseDTO;

interface IAddresseDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(AddresseDTO $addresse);

    public function save (AddresseDTO $addresse);

}