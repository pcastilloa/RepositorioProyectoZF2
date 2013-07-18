<?php
namespace Cargo\Model;

use Zend\Db\TableGateway\TableGateway;

class CargoTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getCargo($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveCargo(Cargo $cargo)
    {
        $data = array(
            'descripcion' => $cargo->descripcion,
            'activo'  => $cargo->activo,
        );

        $id = (int)$cargo->idcargo;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getCargo($id)) {
                $this->tableGateway->update($data, array('idcargo' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }

    public function deleteCargo($id)
    {
        $this->tableGateway->delete(array('id' => $id));
    }
}