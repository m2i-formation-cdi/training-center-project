<?php
namespace m2i\project\Model\DAO;

use m2i\project\Model\Entity\CitieDTO;

interface ICitieDAO {

    public function findAll();

    public function findOneById(array $pk);

    public function find(array $search);

    public function delete(CitieDTO $citie);

    public function save (CitieDTO $citie);

}