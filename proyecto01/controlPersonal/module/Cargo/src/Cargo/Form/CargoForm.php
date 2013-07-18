<?php
namespace Cargo\Form;

use Zend\Form\Form;

class CargoForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('cargo');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'idcargo',
            'type' => 'Hidden',
        ));
        $this->add(array(
            'name' => 'descripcion',
            'type' => 'Text',
            'options' => array(
                'label' => 'Descripcion del cargo:  ',
            ),
        ));
        $this->add(array(
            'name' => 'activo',
            'type' => 'Text',
            'options' => array(
                'label' => 'Estado del cargo: Activo',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }
}