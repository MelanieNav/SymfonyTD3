<?php
/**
 * Created by PhpStorm.
 * User: navea
 * Date: 21/03/2018
 * Time: 13:25
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\StepRepository;
use App\Services\semantic\StepsGui;
use App\Entity\Step;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class StepsController extends CrudController{

    /**
     * @Route("steps", name="steps")
     */
    public function steps(StepsGui $gui,StepRepository $stepRepo){
        $steps=$stepRepo->findAll();
        $gui->dataTable($steps,'steps');
        return $gui->renderView('Steps/index.html.twig');
    }

    /**
     * @Route("step/update/{id}", name="step_update")
     */
    public function update(Step $step,StepsGui $stepsGui){
        $stepsGui->frm($step);
        return $stepsGui->renderView('Steps/frm.html.twig');
    }

    /**
     * @Route("step/submit", name="step_submit")
     */
    public function submit(Request $request,StepRepository $stepRepo){
        $step=$stepRepo->find($request->get("id"));
        if(isset($step)){
            $step->setTitle($request->get("title"));
            $stepRepo->update($step);
        }
        return $this->redirectToRoute("steps");
    }

    /**
     * @Route("step/delete/{id}", name="step_delete")
     */
    public function delete($id,Request $request){
        return $this->_delete($id, $request);
    }

    /**
     * @Route("step/confirmDelete/{id}", name="step_confirm_delete")
     */
    public function deleteConfirm($id){
        return $this->_deleteConfirm($id);
    }

    /**
     * @Route("step/new", name="step_new")
     */
    public function add(){
        return $this->_add("\App\Entity\Step");
    }

    /**
     * @Route("step/refresh", name="step_refresh")
     */
    public function refresh(){
        return $this->_refresh();
    }

    /**
     * @Route("step/edit/{id}", name="step_edit")
     */
    public function edit($id){
        return $this->_edit($id);
    }
}
