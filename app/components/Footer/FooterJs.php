<?php

use Nette\Application\UI;

/**
 * FooterJs
 */
class FooterJs extends UI\Control
{
  /**
   * @var string[]
   */
    protected $jsFiles = [];

  /**
   * FooterJs constructor
   *
   * @param string[] $jsFiles
   */
    public function __construct(array $jsFiles = [])
    {
        $this->jsFiles = $jsFiles;
    }

  /**
   * Default view
   *
   * @return void
   */
    public function render(): void
    {
        $this->template->jsFiles = $this->getJsFiles();

        $this->template->setFile(dirname(__FILE__) . '/template.latte');
        $this->template->render();
    }

  /**
   * Get JS files
   * @return string[]
   */
    private function getJsFiles(): array
    {
        return $this->jsFiles;
    }
}
