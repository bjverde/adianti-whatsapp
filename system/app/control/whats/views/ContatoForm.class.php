<?php
/**
 * System generated by SysGen (System Generator with Formdin Framework) 
 * Download SysGenAd: https://github.com/bjverde/sysgenad
 * Download Formdin5 Framework: https://github.com/bjverde/formDin5
 * 
 * SysGen  Version: 0.6.1
 * FormDin Version: 5.0.0
 * 
 * System aw created in: 2023-08-21 14:08:51
 */

class ContatoForm extends TPage
{

    private static $formId ='form_contatoForm'; //Form ID
    private static $primaryKey ='ID_CONTATO';
    protected $form; //Registration form Adianti
    protected $frm;  //Registration component FormDin 5
    protected $adianti_target_container;
    protected $datagrid; //Listing
    protected $pageNavigation;

    // trait com onReload, onSearch, onDelete, onClear, onEdit, show
    use Adianti\Base\AdiantiStandardFormTrait;
    // trait com onReload, onSearch, onDelete...
    use Adianti\Base\AdiantiStandardListTrait;

    public function __construct($param = null)
    {
        parent::__construct();
        $this->setDatabase('maindatabase'); // define the database
        $this->setActiveRecord('contato'); // define the Active Record
        $this->setDefaultOrder('ID_CONTATO', 'asc'); // define the default order
        if(!empty($param['target_container'])){
            $this->adianti_target_container = $param['target_container'];
        }

        $this->frm = new TFormDin($this,_t('Register').' contato',null,null,self::$formId);
        $frm = $this->frm;
        $frm->enableCSRFProtection(); // Protection cross-site request forgery 
        $frm->addHiddenField( self::$primaryKey );   // coluna chave da tabela
        $frm->addTextField('NOME', 'Nome',50,true,50);
        $frm->addTextField('DDI', 'Ddi',50,true,50);
        $frm->addTextField('DDD', 'Ddd',50,true,50);
        $frm->addTextField('CELULAR', 'Celular',50,true,50);
        $frm->addTextField('ST_WHATSAPP', 'Status Whatsapp',50,false,50);
        $frm->addTextField('AVISADO', 'Avisado',50,false,50);
        $frm->addDateField('DTINCLUSAO', 'Data Inclusão',true,null,null,null,null,'dd/mm/yyyy',null,null,null,null,'yyyy-mm-dd');
        $frm->addDateField('DTALTERACAO', 'Data Alteração',false,null,null,null,null,'dd/mm/yyyy',null,null,null,null,'yyyy-mm-dd');
        $frm->addDateField('DTEXCLUSAO', 'Data Exclusão',false,null,null,null,null,'dd/mm/yyyy',null,null,null,null,'yyyy-mm-dd');

        // O Adianti permite a Internacionalização - A função _t('string') serve
        //para traduzir termos no sistema. Veja ApplicationTranslator escrevendo
        //primeiro em ingles e depois traduzindo
        $frm->setAction( _t('Save'), 'onSave', null, 'fa:save', 'green' );
        $frm->setActionLink( _t('Clear'), 'onClear', null, 'fa:eraser', 'red');
        $frm->setActionLink( _t('Back'), ['contatoFormList','onReload'], null, 'fas:arrow-left', '#000000');

        $this->form = $frm->show();
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data'));
        // creates the page structure using a table
        $formDinBreadCrumb = new TFormDinBreadCrumb(__CLASS__,false);
        $vbox = $formDinBreadCrumb->getAdiantiObj();
        $vbox->add($this->form);

        // add the table inside the page
        parent::add($vbox);
    }

    //--------------------------------------------------------------------------------
    /**
     * Close right panel
     */
     /*
    public function onClose()
    {
        TScript::create("Template.closeRightPanel()");
    } //END onClose
     */

    //--------------------------------------------------------------------------------
    public function onSave($param)
    {
        $data = $this->form->getData();
        //Função do FormDin para Debug
        FormDinHelper::d($param,'$param');
        FormDinHelper::debug($data,'$data');
        FormDinHelper::debug($_REQUEST,'$_REQUEST');

        try{
            $this->form->validate();
            $this->form->setData($data);
            $vo = new ContatoVO();
            $this->frm->setVo( $vo ,$data ,$param );
            $controller = new ContatoController();
            $resultado = $controller->save( $vo );
            if( is_int($resultado) && $resultado!=0 ) {
                //$text = TFormDinMessage::messageTransform($text); //Tranform Array in Msg Adianti
                $this->onReload();
                $this->frm->addMessage( _t('Record saved') );
                //$this->frm->clearFields();
            }else{
                $this->frm->addMessage($resultado);
            }
        }catch (Exception $e){
            new TMessage(TFormDinMessage::TYPE_ERROR, $e->getMessage());
        } //END TryCatch
    } //END onSave

}