<?php
namespace fhu\BootstrapToolbar\Model;

use fhu\BootstrapToolbar\Toolbar;

class Icon
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $icon;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $color;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var bool
     */
    protected $autoCompleteLink;

    /**
     * @var bool
     */
    protected $checkSingleLink;

    /**
     * @var bool
     */
    protected $checkMultipleLink;

    /**
     * @var string
     */
    protected $checkSingleError = 'Select an item to continue';

    /**
     * @var string
     */
    protected $checkMultipleError = 'Select one or more items to continue';

    /**
     * @var string
     */
    protected $checkConfirmMessage = '';

    /**
     * @var Toolbar
     */
    protected $toolbar;

    /**
     * @param $id
     * @param Toolbar $toolbar
     */
    public function __construct($id, Toolbar $toolbar)
    {
        $this->id = $id;
        $this->toolbar = $toolbar;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Icon
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return Icon
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Icon
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Icon
     */
    public function setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        $link = $this->link;

        if ($this->isCheckSingleLink() || $this->isCheckMultipleLink()) {
            return $link;
        }

        if ($this->isAutoCompleteLink()) {
            $parsedUrl = parse_url($_SERVER['REQUEST_URI']);
            $parts = [];

            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $parts);
            }

            $link .= '?' . http_build_query($parts);
        }

        return $link;
    }

    /**
     * @param string $link
     * @return Icon
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoCompleteLink()
    {
        return $this->autoCompleteLink;
    }

    /**
     * @param bool $autoCompleteLink
     * @return Icon
     */
    public function setAutoCompleteLink($autoCompleteLink)
    {
        $this->autoCompleteLink = $autoCompleteLink;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCheckMultipleLink()
    {
        return $this->checkMultipleLink;
    }

    /**
     * @param boolean $checkMultipleLink
     * @return Icon
     */
    public function setCheckMultipleLink($checkMultipleLink)
    {
        $this->checkMultipleLink = $checkMultipleLink;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isCheckSingleLink()
    {
        return $this->checkSingleLink;
    }

    /**
     * @param boolean $checkSingleLink
     * @return Icon
     */
    public function setCheckSingleLink($checkSingleLink)
    {
        $this->checkSingleLink = $checkSingleLink;

        return $this;
    }

    /**
     * @return string
     */
    public function getCheckMultipleError()
    {
        return $this->checkMultipleError;
    }

    /**
     * @param string $checkMultipleError
     * @return Icon
     */
    public function setCheckMultipleError($checkMultipleError)
    {
        $this->checkMultipleError = $checkMultipleError;

        return $this;
    }

    /**
     * @return string
     */
    public function getCheckSingleError()
    {
        return $this->checkSingleError;
    }

    /**
     * @param string $checkSingleError
     * @return Icon
     */
    public function setCheckSingleError($checkSingleError)
    {
        $this->checkSingleError = $checkSingleError;

        return $this;
    }

    /**
     * @return string
     */
    public function getOnClick()
    {
        $jsMethod = 'goToDynamicLink' . $this->toolbar->getRenderCount();
        $linkId = $this->toolbar->config->getLinkId();
        $containerId = $this->toolbar->config->getContainerId();
        $href = $this->getLink();
        $confirm = $this->jsEscape($this->getCheckConfirmMessage());

        if ($this->isCheckSingleLink()) {
            $error = $this->jsEscape($this->getCheckSingleError());

            // href, checkType, linkId, containerId
            return "$jsMethod('{$href}', 'single', '{$linkId}', '{$containerId}', '{$error}', '{$confirm}')";
        }

        if ($this->isCheckMultipleLink()) {
            $error = $this->jsEscape($this->getCheckMultipleError());

            // href, checkType, linkId, containerId
            return "$jsMethod('{$href}', 'multiple', '{$linkId}', '{$containerId}', '{$error}', '{$confirm}')";
        }

        return '';
    }

    protected function jsEscape($value)
    {
        return str_replace(["'", '"'], ["\\'"], $value);
    }

    /**
     * @return string
     */
    public function getCheckConfirmMessage()
    {
        return $this->checkConfirmMessage;
    }

    /**
     * @param string $checkConfirmMessage
     * @return Icon
     */
    public function setCheckConfirmMessage($checkConfirmMessage)
    {
        $this->checkConfirmMessage = $checkConfirmMessage;

        return $this;
    }
}