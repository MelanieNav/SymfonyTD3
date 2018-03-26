<?php

namespace App\Controller;

use App\Repository\StoryRepository;
use App\Services\semantic\StoriesGui;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\TagRepository;
use App\Services\semantic\TagsGui;
use App\Entity\Tag;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StoriesController extends CrudController
{

    public function __construct(StoriesGui $gui, StoryRepository $repo)
    {
        $this->gui = $gui;
        $this->repository = $repo;
        $this->type = "stories";
        $this->subHeader = "Story list";
        $this->icon = "address card outline";
    }

    /**
     * @Route("/stories", name="stories")
     */
    public function index()
    {
        return $this->_index();
    }

    /**
     * @Route("/stories/refresh", name="stories_refresh")
     */
    public function refresh()
    {
        return $this->_refresh();
    }

    /**
     * @Route("/stories/edit/{id}", name="stories_edit")
     */
    public function edit($id)
    {
        return $this->_edit($id);
    }

    /**
     * @Route("/stories/new", name="stories_new")
     */
    public function add()
    {
        return $this->_add("\App\Entity\Story");
    }

    /**
     * @Route("/stories/update", name="stories_update")
     */
    public function update(Request $request)
    {
        return $this->_update($request, "\App\Entity\Story");
    }

    /**
     * @Route("/stories/confirmDelete/{id}", name="stories_confirm_delete")
     */
    public function deleteConfirm($id){
        return $this->_deleteConfirm($id);
    }

    /**
     * @Route("/stories/delete/{id}", name="stories_delete")
     */
    public function delete($id,Request $request){
        return $this->_delete($id, $request);
    }
}