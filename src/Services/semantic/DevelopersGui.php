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
        $dt->setIdentifierFunction("getId");
        $dt->setCaptions(["Developer"]);
        $dt->setValueFunction("developer", function($v,$developer){
            $lbl=new HtmlLabel("",$developer->getIdentity());
            return $lbl;
        });
        $dt->addEditButton();
        $dt->setUrls(["edit"=>"developer/update"]);
        $dt->setTargetSelector("#update-dev");
        $dt->addDeleteButton();
        $dt->setUrls(["delete"=>"developer/delete"]);
        $dt->setTargetSelector("#delete-dv");
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

    public function buttonNewDeveloper(){
        $bt=$this->_semantic->htmlButton("bt1","Ajouter un développeur");
        $bt->getOnClick($this->getUrl("/developer/new"),"#ajout",["attr"=>""]);
        echo $bt;
    }

    public function frmAddDev()
    {
        $dev = new Developer(); // Créer un objet développeur
        $frm=$this->_semantic->dataForm("frm-new-dev",$dev); // Créer la base du formulaire en lui disant qu'on va modifier le développeur
        $frm->setFields(["identity","submit","cancel"]); // Créer les différents champs
        $frm->setCaptions(["Identity","Valider","Annuler"]); // Donne un label à ces champs
        $frm->fieldAsInput("identity",["rules"=>["empty","maxLength[30]"]]); // On dit que le champs identity est un type="text" et qu'il y a des règles
        $frm->setValidationParams(["on"=>"blur","inline"=>true]); // Pas compris
        $frm->onSuccess("$('#frm-new-dev').hide();"); // Quand c'est réussi, on cache le formulaire
        $frm->fieldAsSubmit("submit","positive","developer/submit", "#dtNewDev",["ajax"=>["attr"=>""]]);
        // On dit que le champ submit est le validateur, qu'il a un aspect positif et qu'il déclanche la route submit dans le #dtNewDev
        $frm->fieldAsLink("cancel",["class"=>"ui button cancel"]); // On dit que le champs cancel est un button
        $this->click(".cancel","$('#frm-new-dev').hide();"); // Si on annule, on cache le formulaire
        $frm->addSeparatorAfter("identity"); // Retour à la ligne, c'est plus du design ça
        return $frm;
    }
}