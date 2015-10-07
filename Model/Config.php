<?php
namespace fhu\BootstrapToolbar\Model;

class Config
{
    /**
     * @var string
     */
    protected $toolbarId;

    /**
     * @var bool
     */
    protected $float = false;

    /**
     * @var string
     */
    protected $linkId = 'id';

    /***
     * @var string
     */
    protected $containerId = 'container';

    /**
     * @var string
     */
    protected $floatingTop = '60';

    /**
     * @var string
     */
    protected $floatingOffset = '46';

    /**
     * @return boolean
     */
    public function isFloat()
    {
        return $this->float;
    }

    /**
     * @param boolean $float
     */
    public function setFloat($float)
    {
        $this->float = $float;
    }

    /**
     * @param $linkId The name of the querystring parameter used to send a single or multiple ids.
     * @param $containerId The id of the container that has the checkboxes
     */
    public function setDynamicLinkProperties($linkId, $containerId)
    {
        $this->linkId = $linkId;
        $this->containerId = $containerId;
    }

    /**
     * @return string
     */
    public function getLinkId()
    {
        return $this->linkId;
    }

    /**
     * @return string
     */
    public function getContainerId()
    {
        return $this->containerId;
    }

    /**
     * @return string
     */
    public function getFloatingTop()
    {
        return $this->floatingTop;
    }

    /**
     * @param string $floatingTop
     */
    public function setFloatingTop($floatingTop)
    {
        $this->floatingTop = $floatingTop;
    }

    /**
     * @return string
     */
    public function getFloatingOffset()
    {
        return $this->floatingOffset;
    }

    /**
     * @param string $floatingOffset
     */
    public function setFloatingOffset($floatingOffset)
    {
        $this->floatingOffset = $floatingOffset;
    }

    /**
     * @return string
     */
    public function getToolbarId()
    {
        return $this->toolbarId;
    }

    /**
     * @param string $toolbarId
     */
    public function setToolbarId($toolbarId)
    {
        $this->toolbarId = $toolbarId;
    }
}