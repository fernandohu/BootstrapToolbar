<?php
namespace fhu\BootstrapToolbar;

class Toolbar
{
    /**
     * @var array
     */
    protected $icons = [];

    /**
     * @var string
     */
    protected $toolbarId;

    /**
     * @var bool
     */
    protected $float = false;

    /**
     * @var int
     */
    private static $jsRenderCount = 0;

    /**
     * @var string
     */
    protected $linkId = 'id';

    /***
     * @var string
     */
    protected $containerId = 'container';

    /**
     * @param string $id
     * @param bool $float
     */
    public function __construct($id = 'fhuToolbar', $float = false)
    {
        $this->toolbarId = $id;
        $this->float = $float;
    }

    /**
     * @param string $label
     * @param string $iconClass
     * @param string $iconId
     * @return Icon
     */
    public function addIcon($label, $iconClass, $iconId = '')
    {
        if ($iconId == '') {
            $iconId = $iconClass;
        }

        $icon = new Icon($iconId, $this);
        $icon->setLabel($label);
        $icon->setIcon($iconClass);

        $this->icons[$iconId] = $icon;

        return $icon;
    }

    /**
     * @param string $iconId
     */
    public function removeIcon($iconId)
    {
        unset($this->icons[$iconId]);
    }


    /**
     * @param string $iconId
     * @return Icon
     */
    public function getIcon($iconId)
    {
        return $this->icons[$iconId];
    }

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
     * @return string
     */
    public function render()
    {
        self::$jsRenderCount++;

        $content = '';
        $content .= $this->getCheckLinkJs();

        if ($this->isFloat()) {
            $content .= $this->getFloatJs();
        }

        $content .= '<div class="btn-group" id="' . $this->toolbarId . '">';

        /**
         * @var Icon $icon
         */
        foreach ($this->icons as $icon) {
            $label = $icon->getLabel();
            $class = $icon->getIcon();
            $link = $icon->getLink();
            $click = $icon->getOnClick();
            $onclick = '';
            $linkBegin = '';
            $linkEnd = '';

            if ($link != '') {
                $linkBegin = '<a href="' . $link . '">';
                $linkEnd = '</a>';
            }

            if ($click != '') {
                $onclick = ' onclick="' . $click . '; return false;"';
            }

            $content .= '
    ' . $linkBegin . '<button type="button" class="btn btn-default"' . $onclick . ' aria-label="' . htmlspecialchars($label) . '" title="' . htmlspecialchars($label) . '">
        <span class="glyphicon glyphicon-' . $class . '" aria-hidden="true"></span>
    </button>' . $linkEnd . '
';
        }
        $content .= '</div>';

        return $content;
    }

    /**
     * @return string
     */
    protected function getFloatJs()
    {
        $renderCount = self::$jsRenderCount;

        $content = "
<script>
function floatingToolbar{$renderCount}(toolbarId, topFloatPos, correctionOffset) {
";
        $content .= <<<JSCODE
    var toolbarFloating = false;

    if (typeof topFloatPos == 'undefined')
        topFloatPos = 60;

    if (typeof correctionOffset == 'undefined')
        correctionOffset = 46;

    $(window).bind('scroll', function() {
        var toolbarObj = $('#' + toolbarId);
        var intScrollOffset = $(this).scrollTop();
        var toolbarOffset = 0;

        if (typeof toolbarObj.attr('originalToolbarOffset') == 'undefined') {
            toolbarOffset = toolbarObj.offset().top;
            toolbarObj.attr('originalToolbarOffset', toolbarOffset);
        } else {
            toolbarOffset = toolbarObj.attr('originalToolbarOffset');
        }

        if (toolbarObj.length > 0) {
            if (intScrollOffset + correctionOffset > toolbarOffset) {
                if(toolbarFloating == false) {
                    toolbarObj.css('position', 'fixed');
                    toolbarObj.css('display', 'block');
                    toolbarObj.css('zIndex', '10');
                    toolbarObj.css('top', topFloatPos + 'px');
                    toolbarFloating = true;
                }
            } else {
                if (toolbarFloating == true) {
                    toolbarObj.css('position', 'relative');
                    toolbarObj.css('top', '0px');
                    toolbarFloating = false;
                }
            }
        }
    });

    $(window).trigger('scroll');
}
JSCODE;
        $content .= "
floatingToolbar{$renderCount}('{$this->toolbarId}');
</script>
";

        return $content;
    }

    public function getCheckLinkJs()
    {
        $renderCount = self::$jsRenderCount;

        $content = '
<script>
function goToDynamicLink' . $renderCount . '(href, checkType, linkId, containerId, errorMessage, confirmMessage) {

    if (typeof checkType == \'undefined\')
        checkType = \'single\';

    if (typeof linkId == \'undefined\')
        linkId = \'id\';

    if (typeof containerId == \'undefined\')
        containerId = \'container\';

    if (typeof errorMessage == \'undefined\')
        errorMessage = \'\';

    if (typeof confirmMessage == \'undefined\')
        confirmMessage = \'\';

    var container = document.getElementById(containerId);

    if (container) {
        var inputs = container.getElementsByTagName(\'input\');
        var values = \'\';
        var value = \'\';
        var count = 0;

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type == "checkbox" && inputs[i].checked) {
                values = values + \'&\' + linkId + \'[]=\' + inputs[i].value;
                value = \'&\' + linkId + \'=\' + inputs[i].value;
                count++;
            }
        }

        if (confirmMessage != "") {
            if (!confirm(confirmMessage)) {
                return;
            }
        }

        switch (checkType) {
            case \'single\':
                if (count == 1) {
                    location.href = href + "?" + value;
                } else {
                    alert(errorMessage);
                }
                break;

            case \'multiple\':
                if (count > 0) {
                    location.href = href + "?" + values;
                } else {
                    alert(errorMessage);
                }
                break;

            default:
                return;
                break;
        }
    }
}
</script>
';

        return $content;
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
     * @return int
     */
    public function getRenderCount()
    {
        return self::$jsRenderCount;
    }
}