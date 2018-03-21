<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\TagRepository;
use App\Services\semantic\TagsGui;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class TagsController extends Controller{

    /**
     * @Route("/td3/tags", name="td3_tags")
     */
    public function tags(TagsGui $gui,TagRepository $tagRepo){
    	$tags=$tagRepo->findAll();
    	$gui->dataTable($tags,'tags');
    	return $gui->renderView('Tags/td3/index.html.twig');
    }

    /**
     * @Route("td3/tag/update/{id}", name="td3_tag_update")
     */
    public function update(Tag $tag,TagsGui $tagsGui){
    	$tagsGui->frm($tag);
    	return $tagsGui->renderView('Tags/td3/frm.html.twig');
    }

    /**
     * @Route("td3/tag/submit", name="tag_submit")
     */
    public function submit(Request $request,TagRepository $tagRepo){
    	$tag=$tagRepo->find($request->get("id"));
    	if(isset($tag)){
    		$tag->setTitle($request->get("title"));
    		$tag->setColor($request->get("color"));
    		$tagRepo->update($tag);
    	}
    	return $this->redirectToRoute("td3_tags");
    }

}
