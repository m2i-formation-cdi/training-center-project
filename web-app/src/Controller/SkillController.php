<?php
/**
 * Created by PhpStorm.
 * User: formation
 * Date: 16/08/2017
 * Time: 10:07
 */

namespace m2i\project\Controller;

use m2i\Framework\ServiceContainer as SC;
use m2i\project\Model\DAO\SkillDAO;
use m2i\project\Model\Entity\SkillDTO;

class SkillController
{
    public function newAction() {
        $isSubmitted = filter_has_var(INPUT_POST, 'submit');
        $skill = filter_input(INPUT_POST, 'skillName', FILTER_SANITIZE_STRING);

        $errors = [];
        $message = '';

        $dao = $this->getSkillDAO();

        if ($isSubmitted && !empty($skill)) {
            $newSkill = $this->getSkillDTO();
            $newSkill->setSkillName($skill);

//            $dao = $this->getSkillDAO();
            $objectResult = $dao->find(['skillName'=>$skill]);
            $result = $objectResult->getAllAsArray();
            if (count($result) == 0) {
                $objectResult->save($newSkill);
                $message = 'Competence was added successfully';
            } else {
                $errors[] = 'This skill already exist';
            }
        }

        $skills = $dao->findAll()
            ->getAllAsArray();
        $view = SC::get("view");
        echo $view->renderView("skill/form", ['errors'=>$errors, 'skills'=>$skills, 'message'=>$message]);
    }

    /**
     * @return SkillDTO
     */
    private function getSkillDTO() {
        return SC::get("skill.dto");
    }

    /**
     * @return SkillDAO
     */
    private function getSkillDAO() {
        return SC::get('skill.dao');
    }
}