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

class ContatoFormList extends TPage
{

    private static $formId ='form_contatoFormList'; //Form ID
    private static $primaryKey ='id_contato';
    protected $form; //Registration form Adianti
    protected $frm;  //Registration component FormDin 5
    protected $filter_criteria;
    protected $adianti_target_container;
    protected $datagrid; //Listing
    protected $pageNavigation;
    public $datagrid_form;

    // trait com onReload, onSearch, onDelete, onClear, onEdit, show
    use Adianti\Base\AdiantiStandardFormTrait;
    // trait com onReload, onSearch, onDelete...
    use Adianti\Base\AdiantiStandardListTrait;

    public function __construct($param = null)
    {
        parent::__construct();
        $this->setDatabase('whats_df'); // define the database
        $this->setActiveRecord('contato'); // define the Active Record
        $this->setDefaultOrder(self::$primaryKey, 'desc'); // define the default order
        $this->setLimit(TFormDinGrid::ROWS_PER_PAGE);

        $this->filter_criteria = new TCriteria;
        $this->addFilterField(self::$primaryKey, '=', self::$primaryKey); //campo, operador, campo do form
        $this->addFilterField('nome', 'like', 'nome'); //campo, operador, campo do form
        $this->addFilterField('ddi', '=', 'ddi'); //campo, operador, campo do form
        $this->addFilterField('ddd', '=', 'ddd'); //campo, operador, campo do form
        $this->addFilterField('celular', '=', 'celular'); //campo, operador, campo do form      
          
        if(!empty($param['target_container'])){
            $this->adianti_target_container = $param['target_container'];
        }

        $this->frm = new TFormDin($this,_t('List').' contato',null,null,self::$formId);
        $frm = $this->frm;
        $frm->enableCSRFProtection(); // Protection cross-site request forgery 
        $frm->addHiddenField( self::$primaryKey );   // coluna chave da tabela
        $frm->addTextField('nome', 'Nome',50,false,50);
        $frm->addTextField('ddi', 'DDI',4,false,5);
        $frm->addNumberField('ddd', 'DDD',2,false,0,false);
        $frm->addMaskField('celular', 'Celular',false,'99999-9999',false);
        //$frm->addTextField('ST_WHATSAPP', 'Status Whatsapp',50,false,50);
        //$frm->addTextField('AVISADO', 'Avisado',50,false,50);

        // O Adianti permite a Internacionalização - A função _t('string') serve
        //para traduzir termos no sistema. Veja ApplicationTranslator escrevendo
        //primeiro em ingles e depois traduzindo
        $frm->setActionLink( _t('Search'), 'onSearch', null, 'fas:search', '#2168bd');
        $frm->setActionLink( _t('Clear'), 'onClear', null, 'fa:eraser', 'red');
        $frm->setAction( _t('Register'), ['ContatoForm','onReload'], null, 'fa:plus-square', 'green' );

        $this->form = $frm->show();
        $this->form->setData( TSession::getValue(__CLASS__.'_filter_data'));

        /*
        $mixUpdateFields = self::$primaryKey.'|'.self::$primaryKey
                        .',NOME|NOME'
                        .',DDI|DDI'
                        .',DDD|DDD'
                        .',CELULAR|CELULAR'
                        .',ST_WHATSAPP|ST_WHATSAPP'
                        .',AVISADO|AVISADO'
                        .',DTINCLUSAO|DTINCLUSAO'
                        .',DTALTERACAO|DTALTERACAO'
                        .',DTEXCLUSAO|DTEXCLUSAO'
                        ;
        $grid = new TFormDinGrid($this,'gd','Data Grid');
        $grid->setUpdateFields($mixUpdateFields);
        $grid->addColumn(self::$primaryKey,'id');
        $grid->addColumn('nome','Nome');
        $grid->addColumn('ddi','Ddi');
        $grid->addColumn('ddd','Ddd');
        $grid->addColumn('celular','Celular');
        $grid->addColumn('st_whatsapp','Status Whatsapp');
        $grid->addColumn('avisado','Avisado');

        $this->datagrid = $grid->show();
        $this->pageNavigation = $grid->getPageNavigation();
        $panelGroupGrid = $grid->getPanelGroupGrid();
        */

        //-----------------------------------------------------------
        $this->datagrid_form = new TForm('datagrid_'.self::$formId);
        //$this->datagrid_form->onsubmit = 'return false';

        // creates a Datagrid
        $this->datagrid = new TDataGrid;
        $this->datagrid->disableHtmlConversion();
        $this->datagrid = new BootstrapDatagridWrapper($this->datagrid);
        $this->datagrid->style = 'width: 100%';
        $this->datagrid->disableDefaultClick();

        $column_id_contato = new TDataGridColumn('id_contato', "Id Contato", 'center');
        $column_nome       = new TDataGridColumn('nome', "Nome", 'left');
        $column_ddi        = new TDataGridColumn('ddi', "DDI", 'left');
        $column_ddd        = new TDataGridColumn('ddd', "DDD", 'left');
        $column_celular    = new TDataGridColumn('celular', "Celular", 'left');

        $column_celular->setTransformer(function($value, $object, $row){
            $numeroTelefone = $object->ddi.$object->ddd.$value;
            $msg = 'msg fixa';
            return TFormDinGridTransformer::linkApiWhatsApp($numeroTelefone, $object, $row, $msg, true);
        });


        //<onBeforeColumnsCreation>
        //</onBeforeColumnsCreation>

        $this->datagrid->addColumn($column_id_contato);
        $this->datagrid->addColumn($column_nome);
        $this->datagrid->addColumn($column_ddi);
        $this->datagrid->addColumn($column_ddd);
        $this->datagrid->addColumn($column_celular);

        $action_onEdit = TFormDinGridTransformer::getDataGridActionOnEdit('ContatoForm',self::$primaryKey);
        $this->datagrid->addAction($action_onEdit);
        $action_onDelete = TFormDinGridTransformer::getDataGridActionOnDelete($this,self::$primaryKey);
        $this->datagrid->addAction($action_onDelete);

        // create the datagrid model
        $this->datagrid->createModel();

        // creates the page navigation
        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->enableCounters();
        $this->pageNavigation->setAction(new TAction(array($this, 'onReload')));
        $this->pageNavigation->setWidth($this->datagrid->getWidth());


        $this->datagrid_form->add($this->datagrid);

        $panel = new TPanelGroup('Lista de clientes');
        $panel->datagrid = 'datagrid-container';
        $this->datagridPanel = $panel;
        //$panel->addHeaderActionLink( 'Marcar Avisado', new TAction([$this, 'marcarAvisado']), 'far:check-circle' );
        $panel->add($this->datagrid_form);
        $panel->getBody()->class .= ' table-responsive';
        $panel->addFooter($this->pageNavigation);

        $formDinBreadCrumb = new TFormDinBreadCrumb(__CLASS__);
        $breadCrumb = $formDinBreadCrumb->getAdiantiObj();

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->add($breadCrumb);
        $container->add($this->form);
        $container->add($panel);
        //<onAfterPageCreation>
        //</onAfterPageCreation>

        parent::add($container);
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
    /**
     * Clear filters
     */
    public function onClear()
    {
        $this->clearFilters();
        $this->onReload();
    } //END onClear

    //--------------------------------------------------------------------------------
    /**
     * Usado no TFormDinGrid
     */
    public function setDatagrid_form($datagrid_form)
    {
        if( !is_object($datagrid_form) ){
            throw new InvalidArgumentException(TFormDinMessage::ERROR_FD5_OBJ_ADI);
        }
        $this->datagrid_form = $datagrid_form;
    }
    public function getDatagrid_form()
    {
        return $this->datagrid_form;
    }

}