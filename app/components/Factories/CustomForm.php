<?php

namespace App\Components\Factories;

use App\Forms\CustomFormRenderer;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IContainer;

class CustomForm extends Form
{
  /**
   * Constructor
   * @param IContainer|null $parent
   * @param string|null     $name
   */
    public function __construct(?IContainer $parent = null, ?string $name = null)
    {
        parent::__construct($parent, $name);

        $this->getElementPrototype()->role = 'form';

        // Set custom renderer
        $renderer = new CustomFormRenderer();
        $this->setRenderer($renderer);

        $renderer->wrappers['controls']['container'] = null;
        $renderer->wrappers['label']['container'] = null;
        $renderer->wrappers['control']['container'] = null;

        $renderer->wrappers['pair']['container'] = 'div class="form-floating d-flex"';
        $renderer->wrappers['pair']['checkbox'] = 'div class="form-check mt-3"';
        $renderer->wrappers['pair']['radio'] = 'div class="form-check mt-3"';

        $renderer->wrappers['control']['.text'] = 'form-control';
        $renderer->wrappers['control']['.password'] = 'form-control';
        $renderer->wrappers['control']['.email'] = 'form-control';
        $renderer->wrappers['control']['.textarea'] = 'form-control';

        $renderer->wrappers['control']['.submit'] = 'btn btn-primary mt-3 ms-auto';

        $renderer->wrappers['control']['.checkbox'] = 'form-check-input';
        $renderer->wrappers['control']['.radio'] = 'form-check-input';
        $renderer->wrappers['label']['.checkbox'] = 'form-check-label';
        $renderer->wrappers['label']['.radio'] = 'form-check-label';
    }

  /**
   * Render
   * @param mixed $args
   */
    public function render(...$args): void
    {
        foreach ($this->getControls() as $c) {
            $c->setAttribute('placeholder', $c->caption);
        }
        parent::render();
    }
}
