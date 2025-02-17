<?php

namespace App;

use App\Forms\AdminForm;

/**
 * Description of GlobalPresenter
 *
 */
abstract class GlobalPresenter extends \Nette\Application\UI\Presenter
{
    /**
     * @var string
     */
    public string $title = "";

    /**
     * @var string
     */
    public string $description = "";

    /**
     * @var string
     */
    public string $keywords = "";

    /**
     * @var \IHeaderCssFactory
     */
    private \IHeaderCssFactory $headerFactory;

  /**
   * @var \IFooterJsFactory
   */
    private \IFooterJsFactory $footerFactory;

  /**
   * @var \Nette\DI\Container
   */
    protected $container;

    /**
     * @var \Nette\Database\Explorer
     */
    protected \Nette\Database\Explorer $db;

    /**
     * BasePresenter constructor
     *
     * @param \Nette\DI\Container      $container
     * @param \IHeaderCssFactory       $headerFactory
     * @param \IFooterJsFactory        $footerFactory
     * @param \Nette\Database\Explorer $db
     */
    public function __construct(\Nette\DI\Container $container, \IHeaderCssFactory $headerFactory, \IFooterJsFactory $footerFactory, \Nette\Database\Explorer $db)
    {
        $this->container = $container;
        $this->headerFactory = $headerFactory;
        $this->footerFactory = $footerFactory;
        $this->db = $db;
        parent::__construct();
    }

    /**
     * Startup
     * @return void
     */
    public function startup(): void
    {
        parent::startup();

        $this->title = 'Users';
        $this->description = 'Users manager';
    }

    /**
     * Before render
     * @return void
     */
    public function beforeRender(): void
    {
        parent::beforeRender();
        $this->template->version = 1;

        $this->template->title = $this->title;
        $this->template->description = $this->description;
    }

    /**
     * Render default
     * @return void
     */
    protected function afterRender(): void
    {
        parent::afterRender();
        if ($this->isAjax() && $this->hasFlashSession()) {
            $this->redrawControl("flashMsg");
        }
    }

    /**
   * Header component
   * @return \Header
   */
    protected function createComponentHeaderCss(): \HeaderCss
    {
        return $this->headerFactory->create();
    }

  /**
   * Footer component
   * @return \Footer
   */
    protected function createComponentFooterJs(): \FooterJs
    {
        $footer = $this->footerFactory->create();
        return $footer;
    }
}
