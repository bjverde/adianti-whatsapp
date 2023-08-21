<?php

class Mensagem extends TRecord
{
    const TABLENAME  = 'mensagem';
    const PRIMARYKEY = 'id_mensagem';
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
        parent::addAttribute('mensagem');            
    }    
}