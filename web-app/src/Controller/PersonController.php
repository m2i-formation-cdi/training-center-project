<?php

namespace m2i\project\Controller;


use m2i\Framework\View;
use m2i\project\Model\DAO\PersonDAO;
use m2i\project\Model\Entity\PersonDTO;
use m2i\Framework\ServiceContainer as SC;

class PersonController
{

    public function newAction(){
        $isSubmitted = filter_has_var(INPUT_POST, "submit");
        if($isSubmitted){
            $contact = filter_input(INPUT_POST, "contact",
                FILTER_SANITIZE_STRING, FILTER_REQUIRE_ARRAY);

            $personne = $this->getPersonDTO();
            $personne->hydrate($contact);

            $dao = $this->getPersonDAO();

            $dao->save($personne);
        }

        $view = SC::get("view");
        echo $view->renderView("person/form");
    }

    /**
     * @return PersonDTO
     */
    private function getPersonDTO(){
        return SC::get("person.dto");
    }

    /**
     * @return PersonDAO
     */
    private function getPersonDAO()
    {
        $dao = SC::get("person.dao");
        return $dao;
    }

    /**
     * @param string $postalCode
     */
    public function cityByPostalCodeAction($postalCode){
        $dao = SC::get("city.dao");
        $cities = $dao->find(["postal_code" => $postalCode])->getAllAsArray();

        header("Content-Type: application/json");
        echo json_encode($cities);
    }

}