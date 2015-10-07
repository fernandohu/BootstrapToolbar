<?php

namespace fhu\BootstrapToolbar\Layout;

use fhu\BootstrapToolbar\Toolbar;

abstract class LayoutAbstract
{
    /**
     * @var Toolbar
     */
    protected $toolbar;

    /**
     * @return string
     */
    public abstract function render();

    /**
     * @param Toolbar $toolbar
     */
    public function setToolbar(Toolbar $toolbar)
    {
        $this->toolbar = $toolbar;
    }

    /**
     * @return string
     */
    protected function getFloatJs()
    {
        $renderCount    = $this->toolbar->getRenderCount();
        $floatingPos    = $this->toolbar->config->getFloatingTop();
        $floatingOffset = $this->toolbar->config->getFloatingOffset();
        $toolbarId      = $this->toolbar->config->getToolbarId();

        require(__DIR__ . '/../javascript/float.php');
        return $content;
    }

    /**
     * @return string
     */
    public function getCheckLinkJs()
    {
        $renderCount = $this->toolbar->getRenderCount();
        require(__DIR__ . '/../javascript/dynamiclink.php');
        return $content;
    }
}