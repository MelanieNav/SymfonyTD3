<?php
/**
 * Created by PhpStorm.
 * User: navea
 * Date: 26/03/2018
 * Time: 18:17
 */
namespace App\Services\semantic;

use Ajax\semantic\html\elements\HtmlLabel;
use Ajax\service\JArray;
use App\Entity\Story;

class StoriesGui extends SemanticGui{
    public function dataTable($stories,$type){
        $dt=$this->_semantic->dataTable("dt-".$type, "App\Entity\Story", $stories);
        $dt->setIdentifierFunction("getId");
        $dt->setFields(["story","descriptif"]);
        $dt->setCaptions(["Story","Descriptif"]);
        $dt->setValueFunction("story", function($v,$story){
            $lbl=new HtmlLabel("",$story->getCode());
            return $lbl;
        });
        $dt->setValueFunction("descriptif", function($v,$story){
            $lbl=new HtmlLabel("",$story->getDescriptif());
            return $lbl;
        });
        $dt->addEditDeleteButtons(false, [ "ajaxTransition" => "random","hasLoader"=>false ], function ($bt) {
            $bt->addClass("circular");
        }, function ($bt) {
            $bt->addClass("circular");
        });
        $dt->setUrls(["edit"=>"stories/edit","delete"=>"stories/confirmDelete"]);
        $dt->setTargetSelector("#frm");
        return $dt;
    }

    public function dataForm($story,$type,$di=null){
        $frm=$this->_semantic->dataForm("frm-".$type, $story);
        $frm->setFields(["id","code","descriptif","submit","cancel"]);
        $frm->setCaptions(["","Code","Descriptif","Valider","Annuler"]);
        $frm->fieldAsHidden("id");
        $frm->fieldAsInput("code",["rules"=>["empty","maxLength[30]"]]);
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->onSuccess("$('#frm-stories').hide();");
        $frm->fieldAsSubmit("submit","positive","stories/update", "#frm",["ajax"=>["attr"=>""]]);
        $frm->fieldAsLink("cancel",["class"=>"ui button cancel"]);
        $this->click(".cancel","$('#frm-stories').hide();");
        return $frm;
    }

    public function editStory($story, $steps, $dev){
        $frm=$this->_semantic->dataForm("", $story);
        $frm->setFields(["id","idStep", "idDev"]);
        $frm->setCaptions(["","Story", "Developer"]);
        $frm->fieldAsHidden("id");
        $frm->fieldAsDropDown("idStep",JArray::modelArray($steps,"getId","getTitle"));
        $frm->fieldAsDropDown("idDev",JArray::modelArray($dev,"getId","getIdentity"));
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->setSubmitParams("projects/update","#frm",["attr"=>"","hasLoader"=>false]);
        return $frm;
    }
}