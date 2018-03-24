<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 21/03/2018
 * Time: 15:31
 */

namespace App\Services\semantic;


use Ajax\semantic\html\elements\HtmlLabel;
use Ajax\service\JArray;
use App\Entity\Story;

class TasksGui extends SemanticGui
{
    public function dataTable($tasks,$type){
        $dt=$this->_semantic->dataTable("dt-".$type, "App\Entity\Task", $tasks);
        $dt->setIdentifierFunction("getId");
        $dt->setFields(["content","story"]);
        $dt->setCaptions(["Content","Story"]);
        $dt->setValueFunction("content", function($v,$task){
            $lbl=new HtmlLabel("",$task->getContent());
            return $lbl;
        });
        $dt->setValueFunction("story", function($story){
            if(isset($story)){
                return new HtmlLabel("",$story,"user");
            }
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

    public function dataForm($task,$type,$di=null){
        $frm=$this->_semantic->dataForm("frm-".$type, $task);
        if($task->getStory()!=null){
            $task->idStory=$task->getStory()->getId();
        }
        $frm->setFields(["id","content","idStory"]);
        $frm->setCaptions(["","Content","Story"]);
        $frm->fieldAsHidden("id");
        $frm->fieldAsInput("content",["rules"=>["empty","maxLength[30]"]]);
        $frm->fieldAsDropDown("idStory",JArray::modelArray($di,"getId","getDescriptif"));
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->setSubmitParams("tasks/update","#frm",["attr"=>"","hasLoader"=>false]);
        $frm->addSeparatorAfter("idStory");
        return $frm;
    }
}