<?php
namespace Cargo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Cargo\Model\Cargo;          // <-- Add this import
use Cargo\Form\CargoForm;       // <-- Add this import

class CargoController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'cargos' => $this->getCargoTable()->fetchAll(),            
        ));
    }

    public function deleteAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('cargo');
    	}

    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$del = $request->getPost('del', 'No');

    		if ($del == 'Yes') {
    			$id = (int) $request->getPost('id');
    			$this->getCargoTable()->deleteCargo($id);
    		}

    		// Redirect to list of albums
    		return $this->redirect()->toRoute('cargo');
    	}

    	return array(
    			'id'    => $id,
    			'cargo' => $this->getCargoTable()->getCargo($id)
    	);
    }

    protected $cargoTable;
    public function getCargoTable()
    {
    	if (!$this->cargoTable) {
    		$sm = $this->getServiceLocator();
    		$this->cargoTable = $sm->get('Cargo\Model\CargoTable');
    	}
    	return $this->cargoTable;
    }
    
    public function addAction()
    {
    	$form = new CargoForm();
    	$form->get('submit')->setValue('Agregar');
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$cargo = new Cargo();
    		$form->setInputFilter($cargo->getInputFilter());
    		$form->setData($request->getPost());
    
    		if ($form->isValid()) {
    			$cargo->exchangeArray($form->getData());
    			$this->getCargoTable()->saveCargo($cargo);
    
    			// Redirect to list of albums
    			return $this->redirect()->toRoute('cargo');
    		}
    	}
    	return array('form' => $form);
    }
    
    public function editAction()
    {
    	$id = (int) $this->params()->fromRoute('id', 0);
    	if (!$id) {
    		return $this->redirect()->toRoute('cargo', array(
    				'action' => 'add'
    		));
    	}
    
    	// Get the Album with the specified id.  An exception is thrown
    	// if it cannot be found, in which case go to the index page.
    	try {
    		$cargo = $this->getCargoTable()->getCargo($id);
    	}
    	catch (\Exception $ex) {
    		return $this->redirect()->toRoute('cargo', array(
    				'action' => 'index'
    		));
    	}
    
    	$form  = new CargoForm();
    	$form->bind($cargo);
    	$form->get('submit')->setAttribute('value', 'Edit');
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$form->setInputFilter($cargo->getInputFilter());
    		$form->setData($request->getPost());
    
    		if ($form->isValid()) {
    			$this->getCargoTable()->saveCargo($cargo);
    
    			// Redirect to list of cargos
    			return $this->redirect()->toRoute('cargo');
    		}
    	}
    
    	return array(
    			'id' => $id,
    			'form' => $form,
    	);
    }
}