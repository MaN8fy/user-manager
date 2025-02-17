<?php

namespace App\Forms;

use Nette\Forms\Rendering\DefaultFormRenderer;
use Nette\Utils\Html;

class CustomFormRenderer extends DefaultFormRenderer
{
    /**
     * render label
     *
     * @param \Nette\Forms\Control $control
     * @return Html
     */
    public function renderLabel(\Nette\Forms\Control $control): Html
    {
        if ($control instanceof \Nette\Forms\Controls\Checkbox || $control instanceof \Nette\Forms\Controls\RadioList) {
            $type = $control instanceof \Nette\Forms\Controls\Checkbox ? 'checkbox' : 'radio';
            $label = Html::el('label')
                ->for($control->getHtmlId())
                ->class($this->getValue("label ." . $type . ""), true)
                ->setText($control->getCaption());
            return $this->getWrapper('label container')->setHtml((string) $label);
        }
        return parent::renderLabel($control);
    }

    /**
     * render control
     *
     * @param \Nette\Forms\Control $control
     * @return Html
     */
    public function renderControl(\Nette\Forms\Control $control): Html
    {
        if ($control instanceof \Nette\Forms\Controls\Checkbox || $control instanceof \Nette\Forms\Controls\RadioList) {
            $body = $this->getWrapper('control container');
            if ($this->counter % 2) {
                $body->class($this->getValue('control .odd'), true);
            }

            if (!$this->getWrapper('pair container')->getName()) {
                $body->class($control->getOption('class'), true);
                $body->id = $control->getOption('id');
            }

            $description = $control->getOption('description');
            if ($description instanceof \Nette\HtmlStringable) {
                $description = ' ' . $description;
            } elseif ($description != null) {
                if ($control instanceof \Nette\Forms\Controls\BaseControl) {
                    $description = $control->translate($description);
                }

                $description = ' ' . $this->getWrapper('control description')->setText($description);
            } else {
                $description = '';
            }

            if ($control->isRequired()) {
                $description = $this->getValue('control requiredsuffix') . $description;
            }

            $els = $errors = [];
            renderControl:
            $control->setOption('rendered', true);
            $el = $control->getControlPart();
            if ($el instanceof Html) {
                if ($el->getName() === 'input') {
                    $el->class($this->getValue("control .$el->type"), true);
                }

                $el->class($this->getValue('control .error'), $control->hasErrors());
            }

            $els[] = $el;
            $errors = array_merge($errors, $control->getErrors());
            if ($nextTo = $control->getOption('nextTo')) {
                $control = $control->getForm()->getComponent($nextTo);
                $body->class($this->getValue('control .multi'), true);
                goto renderControl;
            }
            return $body->setHtml(implode('', $els) . $description . $this->doRenderErrors($errors, true));
        }

        return parent::renderControl($control);
    }

    /**
     * render pair
     *
     * @param \Nette\Forms\Control $control
     * @return string
     */
    public function renderPair(\Nette\Forms\Control $control): string
    {
        $type = 'container';
        if ($control instanceof \Nette\Forms\Controls\Checkbox) {
            $type = 'checkbox';
        } elseif ($control instanceof \Nette\Forms\Controls\RadioList) {
            $type = 'radio';
        }
        $pair = $this->getWrapper('pair ' . $type);
        $pair->addHtml($this->renderControl($control));
        $pair->addHtml($this->renderLabel($control));
        $pair->class($this->getValue($control->isRequired() ? 'pair .required' : 'pair .optional'), true);
        $pair->class($control->hasErrors() ? $this->getValue('pair .error') : null, true);
        $pair->class($control->getOption('class'), true);
        if (++$this->counter % 2) {
            $pair->class($this->getValue('pair .odd'), true);
        }

        $pair->id = $control->getOption('id');
        return $pair->render(0);
    }

    /**
     * render errors
     *
     * @param array   $errors
     * @param boolean $control
     * @return string
     */
    private function doRenderErrors(array $errors, bool $control): string
    {
        if (!$errors) {
            return '';
        }

        $container = $this->getWrapper($control ? 'control errorcontainer' : 'error container');
        $itemPrototype = $this->getWrapper($control ? 'control erroritem' : 'error item');
        foreach ($errors as $error) {
            $item = clone $itemPrototype;
            if ($error instanceof \Nette\HtmlStringable) {
                $item->addHtml($error);
            } else {
                $item->setText($error);
            }

            $container->addHtml($item);
        }

        return $control
        ? "\n\t" . $container->render()
        : "\n" . $container->render(0);
    }
}
