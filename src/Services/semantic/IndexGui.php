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
    public function element($type,$display,$icone="tool"){
        $card=$this->_semantic->htmlCard("card-".$type);
        $card->addItemHeaderContent($type);

        $content=$card->addItemContent();
        $content->addIcon($icone)->setSize("big");
        $content->addMeta("2 items","right"); // A update à partir de la base

        $content2=$card->addExtraContent();
        if($display){
            $button=$this->_semantic->htmlButton("bt-display-all-".$type,"See all");
            $button->setAnimated(new HtmlIcon("","eye"),"fade right");
            //$button->getOn("click","/developers/new","#resp",array("data-ajax"=>"developers"));
            $content2->addContent($button);
        }
        $button=$this->_semantic->htmlButton("bt-add-new-".$type,"Add new...");
        $button->setAnimated(new HtmlIcon("","plus"),"fade right");
        $button->getOnClick("developers/new","#add"); // Direction à faire pour ajouter un element. On modifiera developers par la suite quand ça fonctionnera
        $content2->addContent($button);

        return $card;
    }

    public function board(){
        $grid=$this->_semantic->htmlGrid("grille",3,2);
        $cellDev = $grid->getCell(0,0);
        $cellDev->setValue($this->element("Developer",true,"user"));
        $cellProject = $grid->getCell(1,0);
        $cellProject->setValue($this->element("Project",true, "calendar alternate outline"));
        $cellStory = $grid->getCell(2,0);
        $cellStory->setValue($this->element("Story",false,"id card outline icon"));
        $cellTask = $grid->getCell(0,1);
        $cellTask->setValue($this->element("Task",true,"tasks"));
        $cellStep = $grid->getCell(1,1);
        $cellStep->setValue($this->element("Step",true,"step forward icon"));
        $cellTag = $grid->getCell(2,1);
        $cellTag->setValue($this->element("Tag",true,"tag"));
        return $grid;
    }
}