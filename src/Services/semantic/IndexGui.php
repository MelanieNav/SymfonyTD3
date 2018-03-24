<?php
/**
 * Created by PhpStorm.
 * User: Thomas
 * Date: 24/03/2018
 * Time: 10:26
 */

namespace App\Services\semantic;


use Ajax\semantic\html\collections\HtmlMessage;
use Ajax\semantic\html\collections\menus\HtmlMenu;
use Ajax\semantic\html\elements\HtmlIcon;
use Ajax\ui\Components\Button;
use Ajax\semantic\html\elements\HtmlInput;
use Ajax\semantic\html\elements\HtmlImage;

class IndexGui extends SemanticGui
{
    public function element($type,$display,$route,$icone="tool",$entityManager){
        $Repo=$entityManager->getRepository("\App\Entity\\".$type);
        $nb = count($Repo->findAll()); // Perfectible, si on pouvait juste faire une requete count() sur la base
        
        $card=$this->_semantic->htmlCard("card-".$type);
        $card->addItemHeaderContent($type);

        $content=$card->addItemContent();
        $content->addIcon($icone)->setSize("big");
        $content->addMeta($nb." items","right"); // A update à partir de la base

        $content2=$card->addExtraContent();
        if($display){
            $button=$this->_semantic->htmlButton("bt-display-all-".$type,"See all");
            $button->setAnimated(new HtmlIcon("","eye"),"fade right");
            $button->getOnClick($route,"#block-body",["attr"=>""]);
            $content2->addContent($button);
        }
        $button=$this->_semantic->htmlButton("bt-add-new-".$type,"Add new...");
        $button->setAnimated(new HtmlIcon("","plus"),"fade right");
        $button->getOnClick($route."/new","#block-body",["attr"=>"","hasLoader"=>"false"]);
        $content2->addContent($button);

        return $card;
    }

    public function board($entityManager){
        $grid=$this->_semantic->htmlGrid("grille",3,2);
        $cellDev = $grid->getCell(0,0);
        $cellDev->setValue($this->element("Developer",true,"developers","user",$entityManager));
        $cellProject = $grid->getCell(1,0);
        $cellProject->setValue($this->element("Project",true, "projects","calendar alternate outline",$entityManager));
        $cellStory = $grid->getCell(2,0);
        $cellStory->setValue($this->element("Story",false,"stories","id card outline icon",$entityManager));
        $cellTask = $grid->getCell(0,1);
        $cellTask->setValue($this->element("Task",true,"tasks","tasks",$entityManager));
        $cellStep = $grid->getCell(1,1);
        $cellStep->setValue($this->element("Step",true,"steps","step forward icon",$entityManager));
        $cellTag = $grid->getCell(2,1);
        $cellTag->setValue($this->element("Tag",true,"tags","tag",$entityManager));
        return $grid;
    }
}