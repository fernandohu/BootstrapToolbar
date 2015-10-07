<?php
namespace fhu\BootstrapToolbar\Model;

use fhu\BootstrapToolbar\Toolbar;

class Icons
{
    /**
     * @var array
     */
    protected $icons = [];

    /**
     * @var Toolbar
     */
    protected $toolbar;

    public function __construct(Toolbar $toolbar)
    {
        $this->toolbar = $toolbar;
    }

    /**
     * @param string $label
     * @param string $iconClass
     * @param string $iconId
     * @return Icon
     */
    public function add($label, $iconClass, $iconId = '')
    {
        if ($iconId == '') {
            $iconId = $iconClass;
        }

        $icon = new Icon($iconId, $this->toolbar);
        $icon->setLabel($label);
        $icon->setIcon($iconClass);

        $this->icons[$iconId] = $icon;

        return $icon;
    }

    /**
     * @param string $iconId
     */
    public function remove($iconId)
    {
        unset($this->icons[$iconId]);
    }


    /**
     * @param string $iconId
     * @return Icon
     */
    public function get($iconId)
    {
        return $this->icons[$iconId];
    }

    /**
     * @return array
     */
    public function getIcons()
    {
        return $this->icons;
    }
}