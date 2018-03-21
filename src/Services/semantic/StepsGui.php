<?php
/**
 * Created by PhpStorm.
 * User: navea
 * Date: 21/03/2018
 * Time: 13:39
 */


namespace App\Services\semantic;

use Ajax\semantic\html\elements\HtmlLabel;
use App\Entity\Step;

class StepsGui extends SemanticGui{
    public function dataTable($steps,$type){
        $dt=$this->_semantic->dataTable("dt-".$type, "App\Entity\Step", $steps);
        $dt->setIdentifierFunction("getId");
        $dt->setFields(["step"]);
        $dt->setCaptions(["Steps"]);
        $dt->setValueFunction("step", function($v,$step){
            $lbl=new HtmlLabel("",$step->getTitle());
            return $lbl;
        });
        $dt->addEditDeleteButtons(false, [ "ajaxTransition" => "random","hasLoader"=>false ], function ($bt) {
            $bt->addClass("circular");
        }, function ($bt) {
            $bt->addClass("circular");
        });
        $dt->setUrls(["edit"=>"steps/edit","delete"=>"steps/confirmDelete"]);
        $dt->setTargetSelector("#frm");
        return $dt;
    }

    public function dataForm($step,$type,$di=null){
        $frm=$this->_semantic->dataForm("frm-".$type, $step);
        $frm->setFields(["id","title","submit","cancel"]);
        $frm->setCaptions(["","Title","Valider","Annuler"]);
        $frm->fieldAsHidden("id");
        $frm->fieldAsInput("title",["rules"=>["empty","maxLength[30]"]]);
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->onSuccess("$('#frm-steps').hide();");
        $frm->fieldAsSubmit("submit","positive","steps/update", "#frm",["ajax"=>["attr"=>""]]);
        $frm->fieldAsLink("cancel",["class"=>"ui button cancel"]);
        $this->click(".cancel","$('#frm-steps').hide();");
        return $frm;
    }
}

