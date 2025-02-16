<?php

use Nette\Application\UI;

/**
 * HeaderCss
 */
class HeaderCss extends UI\Control
{
  /**
   * @var string[]
   */
    protected $cssFiles = [];

  /**
   * HeaderCss constructor
   *
   * @param string[] $cssFiles
   */
    public function __construct(array $cssFiles = [])
    {

        $this->cssFiles = $cssFiles;
    }

  /**
   * Default view
   *
   * @return void
   */
    public function render(): void
    {

        $this->template->cssFiles = $this->cssFiles;

        $this->template->setFile(dirname(__FILE__) . '/template.latte');
        $this->template->render();
    }
}
