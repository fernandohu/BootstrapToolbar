<?php
namespace fhu\BootstrapToolbar;

use fhu\BootstrapToolbar\Layout\Generic,
    fhu\BootstrapToolbar\Layout\LayoutAbstract,
    fhu\BootstrapToolbar\Model\Config,
    fhu\BootstrapToolbar\Model\Icons;

class Toolbar
{
    /**
     * @var Icons
     */
    public $icons;

    /**
     * @var Config
     */
    public $config;

    /**
     * @var LayoutAbstract
     */
    protected $layout;

    /**
     * @var int
     */
    private static $jsRenderCount = 0;

    /**
     * @param string $id
     * @param bool $float
     */
    public function __construct($id = 'fhuToolbar', $float = false)
    {
        $this->config = new Config();
        $this->config->setToolbarId($id);
        $this->config->setFloat($float);

        $this->icons = new Icons($this);
    }

    /**
     * @return LayoutAbstract
     */
    public function getLayout()
    {
        if (!$this->layout instanceof LayoutAbstract) {
            $this->layout = new Generic();
        }

        return $this->layout;
    }

    /**
     * @param LayoutAbstract $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    /**
     * @return string
     */
    public function render()
    {
        self::$jsRenderCount++;

        $this->getLayout()->setToolbar($this);
        return $this->getLayout()->render();
    }

    /**
     * @return int
     */
    public function getRenderCount()
    {
        return self::$jsRenderCount;
    }
}