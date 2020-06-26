<?php

 namespace Cadret;

 abstract class AbstractRepository
 {
    protected $entity; 

    protected function getEntityManager($classe)
    {
        $this->entity = $classe;
        return BddConnectMySql::getDb();
    }
}