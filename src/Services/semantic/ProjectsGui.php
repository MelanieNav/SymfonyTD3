<?php
namespace App\Services\semantic;

use Ajax\php\symfony\JquerySemantic;
use Ajax\semantic\html\elements\HtmlLabel;
use App\Entity\Project;

class ProjectsGui extends JquerySemantic{
    public function button(){
        $bt=$this->semantic()->htmlButton("btProjects","Projets","orange");
        $bt->getOnClick($this->getUrl("/projects"),"#response",["attr"=>""]);
        return $bt;
    }
    public function buttons(){
        $bts=$this->_semantic->htmlButtonGroups("bts",["Projects","Tags","Developers"]);
        $bts->addIcons(["folder","tags","user"]);
        $bts->setPropertyValues("data-url", ["projects","tags","developers"]);
        $bts->getOnClick("","#response",["attr"=>"data-url"]);
    }

    public function dataTable($projects){
        $dt=$this->_semantic->dataTable("dtProject", "App\Entity\Project", $projects);
        $dt->setFields(["project","descriptif", "startDate", "dueDate"]);
        $dt->setIdentifierFunction("getId");
        $dt->setCaptions(["Project","Description","Date début", "Date du rendu"]);
        $dt->setValueFunction("project", function($v,$project){
            return $project->getName();
        });
        $dt->setValueFunction("descriptif", function($v,$project){
            return $project->getDescriptif();
        });
        $dt->setValueFunction("startDate", function($v,$project){
            return $project->getStartDate()->format('d-m-Y');
        });
        $dt->setValueFunction("dueDate", function($v,$project){
            return $project->getDueDate()->format('d-m-Y');
        });
        $dt->addEditButton();
        $dt->setUrls(["edit"=>"project/update"]);
        $dt->setTargetSelector("#update-project");
        return $dt;
    }

    public function frm(Project $project){
        $frm=$this->_semantic->dataForm("frm-project", $project);
        $frm->setFields(["id","name","submit","cancel"]);
        $frm->setCaptions(["","Identity","Valider","Annuler"]);
        $frm->fieldAsInput("project",["rules"=>["empty","maxLength[50]"]]);
        $frm->fieldAsHidden("id");
        $frm->setValidationParams(["on"=>"blur","inline"=>true]);
        $frm->onSuccess("$('#frm-project').hide();");
        $frm->fieldAsSubmit("submit","positive","project/submit", "#dtProject",["ajax"=>["attr"=>"","jqueryDone"=>"replaceWith"]]);
        $frm->fieldAsLink("cancel",["class"=>"ui button cancel"]);
        $this->click(".cancel","$('#frm-project').hide();");
        $frm->addSeparatorAfter("name");
        return $frm;
    }
}