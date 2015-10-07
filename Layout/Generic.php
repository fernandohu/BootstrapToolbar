<?php
namespace fhu\BootstrapToolbar\Layout;

class Generic extends LayoutAbstract
{
    /**
     * @return string
     */
    public function render()
    {
        $content = '';
        $content .= $this->renderJs();
        $content .= $this->renderHeader();

        /**
         * @var Icon $icon
         */
        foreach ($this->toolbar->icons->getIcons() as $icon) {
            $label   = $icon->getLabel();
            $class   = $icon->getIcon();
            $link    = $icon->getLink();
            $click   = $icon->getOnClick();
            $onclick = $linkBegin = $linkEnd = '';

            if ($link != '') {
                $linkBegin = '<a href="' . $link . '">';
                $linkEnd = '</a>';
            }

            if ($click != '') {
                $onclick = ' onclick="' . $click . '; return false;"';
            }

            $content .= $this->renderIcon($linkBegin, $linkEnd, $onclick, $label, $class);
        }

        $content .= $this->renderFooter();

        return $content;
    }

    /**
     * @return string
     */
    protected function renderHeader()
    {
        $content = '<div class="btn-group" id="' . $this->toolbar->config->getToolbarId() . '">';
        return $content;
    }

    /**
     * @param $linkBegin
     * @param $linkEnd
     * @param $onclick
     * @param $label
     * @param $class
     * @return string
     */
    protected function renderIcon($linkBegin, $linkEnd, $onclick, $label, $class)
    {
        $content = '
    ' . $linkBegin . '<button type="button" class="btn btn-default"' . $onclick . ' aria-label="' . htmlspecialchars($label) . '" title="' . htmlspecialchars($label) . '">
        <span class="glyphicon glyphicon-' . $class . '" aria-hidden="true"></span>
    </button>' . $linkEnd . '
';
        return $content;
    }

    /**
     * @return string
     */
    protected function renderFooter()
    {
        $content = '</div>';
        return $content;
    }

    /**
     * @return string
     */
    protected function renderJs()
    {
        $content = $this->getCheckLinkJs();

        if ($this->toolbar->config->isFloat()) {
            $content .= $this->getFloatJs();
        }

        return $content;
    }
}