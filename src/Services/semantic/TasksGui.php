<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/03/2018
 * Time: 15:31
 */

namespace App\Services\semantic;


use Ajax\semantic\html\elements\HtmlLabel;

class TasksGui extends SemanticGui
{
    public function dataTable($tasks,$type){
        $dt=$this->_semantic->dataTable("dt-".$type, "App\Entity\Task", $tasks);
        $dt->setIdentifierFunction("getId");
        $dt->setFields(["content"]);
        $dt->setCaptions(["Content"]);
        $dt->setValueFunction("task", function($v,$task){
            $lbl=new HtmlLabel("",$task->getContent());
            return $lbl;
        });
        $dt->addEditDeleteButtons(false, [ "ajaxTransition" => "random","hasLoader"=>false ], function ($bt) {
            $bt->addClass("circular");
        }, function ($bt) {
            $bt->addClass("circular");
        });
        $dt->setUrls(["edit"=>"tasks/edit","delete"=>"tasks/confirmDelete"]);
        $dt->setTargetSelector("#frm");
        return $dt;
    }

    public function dataForm($tag,$type,$di=null){
        $frm=$this->_semantic->dataForm("frm-".$type, $tag);
        $frm->setFields(["id","content","submit","cancel"]);
        $frm->setCaptions(["","Content","Valider","Annuler"]);
        $frm->fieldAsHidden("id");
        $frm->fieldAsInput("content",["rules"=>["empty","maxLength[30]"]]);
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->onSuccess("$('#frm-tasks').hide();");
        $frm->fieldAsSubmit("submit","positive","tasks/update", "#frm",["ajax"=>["attr"=>""]]);
        $frm->fieldAsLink("cancel",["class"=>"ui button cancel"]);
        $this->click(".cancel","$('#frm-tasks').hide();");
        $frm->addSeparatorAfter("content");
        return $frm;
    }
}