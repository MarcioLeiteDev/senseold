<?php



namespace Source\Models;

/**
 * Essa Controller faz controle e cria o Objeto View e Seo para exibição front
 * 
 * @package Source\Core
 */

class Controller
{
    /** @var View */
    protected $view;
    
    /** @var Seo */
    protected $seo;
    
    /** @var Message */
    protected $message;
    
    /**
     * 
     * @param string $pathToViews
     */
    public function __construct(string $pathToViews = null) 
    {
       $this->view = new View($pathToViews);
       $this->seo = new Seo();
       $this->message = new Message();
    }
    
}
