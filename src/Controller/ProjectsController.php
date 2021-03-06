<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\Story;
use App\Repository\StepRepository;
use App\Repository\StoryRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use App\Services\semantic\ProjectsGui;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\DeveloperRepository;
use App\Repository\TagRepository;

class ProjectsController extends CrudController{

	public function __construct(ProjectsGui $gui,ProjectRepository $projectRepo){
		$this->gui=$gui;
		$this->repository=$projectRepo;
		$this->type="projects";
		$this->subHeader="Project list";
		$this->icon="table";
	}
	
	/**
	 * @Route("/projects", name="projects")
	 */
	public function index(){
		return $this->_index();
	}
	
	/**
	 * @Route("/projects/refresh", name="projects_refresh")
	 */
	public function refresh(){
		return $this->_refresh();
	}
	
	/**
	 * @Route("/projects/edit/{id}", name="projects_edit")
	 */
	public function edit($id,DeveloperRepository $devRepo){
		$devs=$devRepo->getAll();
		return $this->_edit($id,$devs);
	}
	
	/**
	 * @Route("/projects/new", name="projects_new")
	 */
	public function add(DeveloperRepository $devRepo){
		$devs=$devRepo->getAll();
		return $this->_add("\App\Entity\Project",$devs);
	}
	
	/**
	 * @Route("/projects/update", name="projects_update")
	 */
	public function update(Request $request){
		return $this->_update($request, "\App\Entity\Project");
	}
	
	/**
	 * @Route("/projects/confirmDelete/{id}", name="projects_confirm_delete")
	 */
	public function deleteConfirm($id){
		return $this->_deleteConfirm($id);
	}
	
	/**
	 * @Route("/projects/delete/{id}", name="projects_delete")
	 */
	public function delete($id,Request $request){
		return $this->_delete($id, $request);
	}
	
    /**
     * @Route("/td3", name="td3_index")
     */
    public function indexTd3(ProjectsGui $gui){
    	$gui->buttons();
        return $gui->renderView('projects/td3/index.html.twig');
    }


    /**
     * @Route("/td3/projects", name="td3_projects")
     */
    public function all(ProjectRepository $projectRepo){
    	$projects=$projectRepo->findAll();
    	return $this->render('projects/td3/all.html.twig',["projects"=>$projects]);
    }
    
    protected function _setValues($instance, Request $request){
    	parent::_setValues($instance, $request);
    	$entityManager = $this->getDoctrine()->getManager();
    	$devRepo=$entityManager->getRepository("\App\Entity\Developer");
    	if($request->get("idOwner")!=null){
	    	$dev=$devRepo->find($request->get("idOwner"));
    		$instance->setOwner($dev);
    	}
    }
    
    /**
     * @Route("/project/{idProject}", name="project_stories")
     */
    public function stories($idProject,TagRepository $tagRepo){
    	$project=$this->repository->get($idProject);
    	$this->gui->getOnClick(".nav-stories", "","#block-body",["attr"=>"data-ajax"]);
        $this->gui->getOnClick("#dashboard-bt", "project/{$idProject}/board","#board-div",["attr"=>""]);
        $this->gui->getOnClick("#add-story-bt", "project/{$idProject}/addStory","#board-div",["attr"=>""]);
    	$this->gui->listStories($project->getStories(),$tagRepo);
    	return $this->gui->renderView("projects/stories.html.twig",["project"=>$project]);
    }

    /**
     * @Route("/project/{idProject}/addStory", name="project_add_story")
     */
    public function frmAddStory($idProject,TagRepository $tagRepo, StoryRepository $storyRepo){
        $stories=$storyRepo->getAll();
        $project=$this->repository->get($idProject);
        $this->gui->getOnClick(".nav-stories", "","#block-body",["attr"=>"data-ajax"]);
        $this->gui->listStories($project->getStories(),$tagRepo);
        return $this->gui->simpleElement($this->gui->add($project,$stories));
    }

    /**
     * @Route("/project/{idProject}/submitAddStory", name="project_submitAddStory")
     */
    public function addStory($idProject,ProjectRepository $repository, TagRepository $tagRepo, StoryRepository $storyRepo, Request $request){
        $project=$this->repository->get($idProject);
        $story = new Story();
        $story->setId($request->get("id"));
        $story->setCode($request->get("code"));
        $story->setDescriptif($request->get("descriptif"));
        $story->setProject($project);
        $storyRepo->update($story);
        $project->setStories($story);
        $repository->update($project);
        $dd = $this->gui->listStories($project->getStories(),$tagRepo);
        return $this->gui->simpleElement($dd);
    }


    /**
     * @Route("/project/{idProject}/board", name="project_story_board")
     */
    public function board($idProject,TagRepository $tagRepo, StoryRepository $storyRepo, StepRepository $stepRepository){
        $project=$this->repository->get($idProject);
        $this->gui->getOnClick(".nav-stories", "","#block-body",["attr"=>"data-ajax"]);
        $this->gui->listStories($project->getStories(),$tagRepo);
        $dd=$this->gui->displaySteps($project,$stepRepository,$tagRepo);
        $this->gui->setDraggable(".drag-item",["attr"=>"data-ajax"]);
        $this->gui->asDropZone(".drop-zone");
        /*$steps = $this->gui->getStepsAndStories($project,$stepRepository);
        echo "<pre>";
        print_r($steps);
        echo "</pre>";*/
        return $this->gui->simpleElement($dd);
    }
}
