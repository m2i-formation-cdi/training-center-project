<?php
/**
 * Created by PhpStorm.
 * User: formation
 * Date: 16/08/2017
 * Time: 10:17
 */

namespace m2i\project\Controller;

use m2i\project\Model\DAO\TrainingProgramDAO;
use m2i\Framework\ServiceContainer as SC;

class TrainingProgramController
{
    public function displayPageAction()
    {

        $view = SC::get("view");
        echo $view->renderView("trainingCourses/trainingPrograms");


    }


    public function displayProgramListAction()
    {

        $dao = $this->getTrainingProgramDao();
        $programs = $dao->findAll();//

        header("Content-Type: application/json");
        echo json_encode($programs->getAllAsArray());



    }


    private function getTrainingProgramDao()
    {
        $dao = SC::get("trainingProgram.dao");
        return $dao;

    }


}