<?php
namespace m2i\Framework;


class View
{

    public function renderView($template, $data = [], $layout="default-layout"){
        $content = $this->getTemplateHtml($template, $data);

        $data ["viewContent"] = $content;

        if(! isset($data["pageTitle"])){
            $data["pageTitle"] = "Mon super site";
        }

        return $this->getTemplateHtml($layout, $data);
    }

    public function getTemplateHtml($template, $data= []){
        ob_start();

        extract($data);

        require VIEW_PATH."/".$template.".php";

        return ob_get_clean();
    }

}