<?php

namespace App\Controller;

use Ajax\php\symfony\JquerySemantic;
use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use App\Repository\ProjectRepository;
use App\Services\semantic\DevelopersGui;
use App\Services\semantic\ProjectsGui;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DevelopersController extends Controller
{

    /**
     * @Route("/developers", name="developers")
     */
    public function index(DevelopersGui $gui,DeveloperRepository $developerRepository){
        $devs=$developerRepository->findAll();
        $bt=$gui->buttonNewDeveloper();
        $dt=$gui->dataTable($devs);
        return $gui->renderView("developers/all.html.twig");
    }
    /**
     * @Route("/developers/refresh", name="developers_refresh")
     */
    public function refresh(DevelopersGui $gui,DeveloperRepository $developerRepository){
        $devs=$developerRepository->findAll();
        return new Response($gui->dataTable($devs));
    }
    /**
     * @Route("developer/submit", name="developers_submit")
     */
    public function submit(Request $request,DeveloperRepository $developerRepository){
        $id=$request->get("id");
        if(isset($id)){
            $dev=$developerRepository->find($id);
            $dev->setIdentity($request->get("identity"));
            $developerRepository->update($dev);
        }
        else{
            $dev = new Developer();
            $dev->setIdentity($request->get("identity"));
            $dev->setId($developerRepository->count(array("id"=>">=0")));
            $developerRepository->update($dev);
        }
        return $this->forward("App\Controller\DevelopersController::refresh");
    }

    /**
     * @Route("developer/update/{id}", name="developer_update")
     */
    public function update(Developer $dev,DevelopersGui $developersGui){
        $developersGui->frm($dev);
        return $developersGui->renderView('developers/index.html.twig');
    }

    /**
     * @Route("developer/delete/{id}", name="developer_delete")
     */
    public function deleteAction($id, DevelopersGui $developersGui, DeveloperRepository $developerRepository)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $developerRepository->findOneBy(["id"=>$id]);
        $em->remove($post);
        $em->flush();

        return $developersGui->renderView('developers/index.html.twig');
    }

    /**
     * @Route("developer/new", name="developer_new")
     */
    public function new(DevelopersGui $developersGui){
        $developersGui->frmAddDev();
        return $developersGui->renderView('developers/new.html.twig');
    }
}
