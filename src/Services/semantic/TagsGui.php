<?php

namespace App\Services\semantic;

use Ajax\semantic\html\elements\HtmlLabel;
use App\Entity\Tag;
use Ajax\semantic\html\base\constants\Color;

class TagsGui extends SemanticGui{
	public function dataTable($tags,$type){
		$dt=$this->_semantic->dataTable("dt-".$type, "App\Entity\Tag", $tags);
        $dt->setIdentifierFunction("getId");
		$dt->setFields(["tag"]);
		$dt->setCaptions(["Tag"]);
		$dt->setValueFunction("tag", function($v,$tag){
			$lbl=new HtmlLabel("",$tag->getTitle());
			$lbl->setColor($tag->getColor());
			return $lbl;
		});
        $dt->addEditDeleteButtons(false, [ "ajaxTransition" => "random","hasLoader"=>false ], function ($bt) {
            $bt->addClass("circular");
        }, function ($bt) {
            $bt->addClass("circular");
        });
        $dt->setUrls(["edit"=>"tags/edit","delete"=>"tags/confirmDelete"]);
		$dt->setTargetSelector("#frm");
		return $dt;
	}

	public function dataForm($tag,$type,$di=null){
		$colors=Color::getConstants();
		$frm=$this->_semantic->dataForm("frm-".$type, $tag);
		$frm->setFields(["id","title","color","submit","cancel"]);
		$frm->setCaptions(["","Title","Color","Valider","Annuler"]);
		$frm->fieldAsHidden("id");
		$frm->fieldAsInput("title",["rules"=>["empty","maxLength[30]"]]);
		$frm->fieldAsDropDown("color",\array_combine($colors,$colors));
		$frm->setValidationParams(["on"=>"blur","inline"=>true]);
		$frm->onSuccess("$('#frm-tags').hide();");
		$frm->fieldAsSubmit("submit","positive","tags/update", "#frm",["ajax"=>["attr"=>""]]);
		$frm->fieldAsLink("cancel",["class"=>"ui button cancel"]);
		$this->click(".cancel","$('#frm-tags').hide();");
		$frm->addSeparatorAfter("color");
		return $frm;
	}
}

