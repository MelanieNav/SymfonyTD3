<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 28/02/2018
 * Time: 09:45
 */

namespace App\Services\semantic;


use Ajax\php\symfony\JquerySemantic;
use Ajax\semantic\html\elements\HtmlLabel;
use App\Entity\Developer;

class DevelopersGui extends JquerySemantic
{
    public function dataTable($developers){
        $dt=$this->_semantic->dataTable("dtDev", "App\Entity\Developer", $developers);
        $dt->setFields(["developer"]);
        $dt->setCaptions(["Developer"]);
        $dt->setValueFunction("developer", function($v,$developer){
            $lbl=new HtmlLabel("",$developer->getIdentity());
            return $lbl;
        });
        $dt->addEditButton();
        $dt->setUrls(["edit"=>"developer/update"]);
        $dt->setTargetSelector("#update-dev");
        return $dt;
    }
    public function frm(Developer $developer){
        $frm=$this->_semantic->dataForm("frm-dev", $developer);
        $frm->setFields(["id","identity","submit","cancel"]);
        $frm->setCaptions(["","Identity","Valider","Annuler"]);
        $frm->fieldAsInput("developer",["rules"=>["empty","maxLength[30]"]]);
        $frm->fieldAsHidden("id");
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->onSuccess("$('#frm-dev').hide();");
        $frm->fieldAsSubmit("submit","positive","developer/submit", "#dtDev",["ajax"=>["attr"=>"","jqueryDone"=>"replaceWith"]]);
        $frm->fieldAsLink("cancel",["class"=>"ui button cancel"]);
        $this->click(".cancel","$('#frm-dev').hide();");
        $frm->addSeparatorAfter("identity");
        return $frm;
    }
}