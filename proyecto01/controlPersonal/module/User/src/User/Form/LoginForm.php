<?php
namespace User\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
	public function __construct($name = null)
	{
		// we want to ignore the name passed
		parent::__construct('login');
		$this->setAttribute('method', 'post');
		$this->add(array(
				'name' => 'usuario',
				'attributes' => array(
						'type'  => 'text',
				),
				'options' => array(
						'label' => 'Usuario:  ',
				),
		));
		$this->add(array(
				'name' => 'clave',
				'attributes' => array(
						'type'  => 'password',
				),
				'options' => array(
						'label' => 'Clave:  ',
				),
		));
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Login',
						'id' => 'submitbutton',
				),
		));
	}
}