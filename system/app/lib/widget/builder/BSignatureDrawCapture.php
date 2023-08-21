<?php
/**
 * Signature pad Widget (also known as Memo)
 *
 * @version    7.3
 * @package    widget
 * @subpackage form
 * @author     Lucas Tomasi
 * @copyright  Copyright (c) 2006 Adianti Solutions Ltd. (http://www.adianti.com.br)
 * @license    http://www.adianti.com.br/framework-license
 */
class BSignatureDrawCapture extends TField implements AdiantiWidgetInterface
{
    protected $id;
    protected $penColor;
    protected $size;
    protected $height;
    
    /**
     * Class Constructor
     * @param $name Widet's name
     */
    public function __construct($name)
    {
        parent::__construct($name);
        $this->id   = 'bsignaturedrawcapture_' . mt_rand(1000000000, 1999999999);
        
        $this->penColor = '#000000';
        $this->tag = new TElement('canvas');
        $this->tag->{'widget'} = 'bsignaturedrawcapture';
    }

    public function getPenColor()
    {
        return $this->penColor;
    }

    public function setPenColor($color)
    {
        $this->penColor = $color;
    }
    
    /**
     * Return the post data
     */
    public function getPostData()
    {
        $name = str_replace(['[',']'], ['',''], $this->name);
        
        if (isset($_POST[$name]))
        {
            return $_POST[$name];
        }
        else
        {
            return '';
        }
    }
    
    /**
     * Define the widget's size
     * @param  $width   Widget's width
     * @param  $height  Widget's height
     */
    public function setSize($width, $height = NULL)
    {
        $width = (strstr($width, '%') !== FALSE) ? $width : "{$width}px";
        $height = (strstr($height, '%') !== FALSE) ? $height : "{$height}px";

        $this->size = $width;
        $this->height = $height;
    }

    /**
     * Show the widget
     */
    public function show()
    {
        $this->tag->{'name'}  = "canvas_{$this->name}";   // tag name
        $this->tag->{'id'}  = "canvas_{$this->id}";   // tag name
        $this->tag->{'class'}  = 'form-control tfield';   // tag name
        $this->tag->{'style'} = "width: {$this->size};height: {$this->height}";
        
        $hidden = new TElement('input');
        $hidden->style = 'display: none';
        $hidden->name = $this->name;
        $hidden->id = $this->id;
        $hidden->value = $this->value;

        $buttonClear = new TElement('button');
        $buttonClear->{'type'} = 'button';
        $buttonClear->{'class'} = 'btn btn-default';
        $buttonClear->{'id'} = "clear_{$this->id}";
        $buttonClear->add(new TImage('fa:eraser red'));
        $buttonClear->add(AdiantiCoreTranslator::translate('Clear'));

        $buttonAdd = new TElement('button');
        $buttonAdd->{'type'} = 'button';
        $buttonAdd->{'class'} = 'btn btn-default';
        $buttonAdd->{'id'} = "add_{$this->id}";
        $buttonAdd->add(new TImage('fa:check green'));
        $buttonAdd->add(AdiantiCoreTranslator::translate('Add'));

        $buttonClose = new TElement('button');
        $buttonClose->{'type'} = 'button';
        $buttonClose->{'class'} = 'btn btn-default';
        $buttonClose->{'id'} = "close_{$this->id}";
        $buttonClose->add(new TImage('fa:times grey'));
        $buttonClose->add(AdiantiCoreTranslator::translate('Close'));

        $actions = new TElement('div');
        $actions->{'class'} = 'bsignaturedrawcapture_actions';
        $actions->add($buttonAdd);
        $actions->add($buttonClear);
        $actions->add($buttonClose);

        $image = new TElement('img');
        $image->id = "image_{$this->id}";
        $image->{'class'} = 'bsignaturedrawcapture_image';
        $image->{'style'} = "width: {$this->size};height: {$this->height}";

        $span = new TElement('span');
        $span->add(new TImage('fa:file-signature grey'));

        $container = new TElement('div');
        $container->{'id'}    = "container_{$this->id}";
        $container->{'class'} = "bsignaturedrawcapture";
        $container->{'style'} = 'display: none';
        $container->add($this->tag);
        $container->add($actions);
        
        $signaturePage = new TElement('div');
        $signaturePage->{'class'} = 'bsignaturedrawcapture_container';
        $signaturePage->add($container);
        $signaturePage->add($hidden);
        $signaturePage->add($image);
        $signaturePage->add($span);
        $signaturePage->show();

        TScript::create("bsignaturedrawcapture_start('{$this->id}', '{$this->value}', '{$this->penColor}')");
    }
}
