<?php
namespace App\Controller;

use App\Entity\Project;
use App\Repository\ProjectRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\semantic\ProjectsGui;

class ProjectsController extends Controller
{
    /**
     * @Route("/index", name="index")
     */
    public function index(ProjectsGui $gui, ProjectRepository $projectRepository){
        $gui->buttons();
        return $gui->renderView('index.html.twig');
    }

    /**
     * @Route("/projects", name="projects")
     */
    public function all(ProjectsGui $gui,ProjectRepository $projectRepository){
        $projects=$projectRepository->findAll();
        $gui->dataTable($projects);
        return $gui->renderView('Projects/all.html.twig');
    }

    /**
     * @Route("project/submit", name="project_submit")
     */
    public function submit(Request $request,ProjectRepository $developerRepository){
        $id=$request->get("id");
        if(isset($id)){
            $dev=$developerRepository->find($id);
            $dev->setIdentity($request->get("name"));
            $developerRepository->update($dev);
        }
        else{
            $dev = new Project();
            $dev->setName($request->get("name"));
            $dev->setId($developerRepository->count(array("id"=>">=0")));
            $developerRepository->update($dev);
        }
        return $this->forward("App\Controller\ProjectsController::refresh");
    }

    /**
     * @Route("project/update/{id}", name="project_update")
     */
    public function update(Project $dev,ProjectsGui $developersGui){
        $developersGui->frm($dev);
        return $developersGui->renderView('Projects/index.html.twig');
    }

    /**
     * @Route("project/new", name="project_new")
     */
    public function new(ProjectsGui $developersGui){
        $developersGui->frmAddDev();
        return $developersGui->renderView('Projects/new.html.twig');
    }
}