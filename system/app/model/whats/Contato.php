<?php

class Contato extends TRecord
{
    const TABLENAME  = 'contato';
    const PRIMARYKEY = 'id_contato';
    const IDPOLICY   =  'serial'; // {max, serial}

    const DELETEDAT  = 'dtExclusao';
    const CREATEDAT  = 'dtInclusao';
    const UPDATEDAT  = 'dtAlteracao';    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
        parent::addAttribute('ddi');
        parent::addAttribute('ddd');
        parent::addAttribute('celular');
        parent::addAttribute('st_whatsapp');
        parent::addAttribute('avisado');
        parent::addAttribute('dtInclusao');
        parent::addAttribute('dtAlteracao');
        parent::addAttribute('dtExclusao');
    }
}
?>