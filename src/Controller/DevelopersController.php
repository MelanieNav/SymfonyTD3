<?php

namespace App\Controller;

use Ajax\php\symfony\JquerySemantic;
use App\Entity\Developer;
use App\Repository\DeveloperRepository;
use App\Repository\ProjectRepository;
use App\Services\semantic\DevelopersGui;
use App\Services\semantic\ProjectsGui;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DevelopersController extends Controller
{

    /**
     * @Route("/developers", name="developers")
     */
    public function index(DevelopersGui $gui,DeveloperRepository $developerRepository){
        $devs=$developerRepository->findAll();
        $dt=$gui->dataTable($devs);
        return $gui->renderView("developers/all.html.twig");
    }
    /**
     * @Route("developer/submit", name="developers_submit")
     */
    public function submit(Request $request,DeveloperRepository $developerRepository){
        $dev=$developerRepository->find($request->get("id"));
        if(isset($dev)){
            $dev->setIdentity($request->get("identity"));
            $developerRepository->update($dev);
        }
        return $this->forward("App\Controller\DevelopersController::index");
    }

    /**
     * @Route("developer/update/{id}", name="developer_update")
     */
    public function update(Developer $dev,DevelopersGui $developersGui){
        $developersGui->frm($dev);
        return $developersGui->renderView('developers/index.html.twig');
    }
}
