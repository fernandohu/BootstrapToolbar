<?php
$content = "
<script>
function floatingToolbar{$renderCount}(toolbarId, topFloatPos, correctionOffset) {
";

$content .= <<<JSCODE
    var isToolbarFloating = false;

    if (typeof topFloatPos == 'undefined')
        topFloatPos = 60;

    if (typeof correctionOffset == 'undefined')
        correctionOffset = 46;

    topFloatPos = parseFloat(topFloatPos);
    correctionOffset = parseFloat(correctionOffset);

    $(window).bind('scroll', function() {
        var toolbarObj = $('#' + toolbarId);
        var scrollOffset = $(this).scrollTop();
        var toolbarOffset = 0;

        if (typeof toolbarObj.attr('originalToolbarOffset') == 'undefined') {
            toolbarOffset = toolbarObj.offset().top;
            toolbarObj.attr('originalToolbarOffset', toolbarOffset);
        } else {
            toolbarOffset = toolbarObj.attr('originalToolbarOffset');
        }

        if (toolbarObj.length > 0) {
            if (scrollOffset + correctionOffset > toolbarOffset) {
                if(isToolbarFloating == false) {
                    toolbarObj.css('position', 'fixed');
                    toolbarObj.css('display', 'block');
                    toolbarObj.css('zIndex', '10');
                    toolbarObj.css('top', topFloatPos + 'px');
                    isToolbarFloating = true;
                }
            } else {
                if (isToolbarFloating == true) {
                    toolbarObj.css('position', 'relative');
                    toolbarObj.css('top', '0px');
                    isToolbarFloating = false;
                }
            }
        }
    });

    $(window).trigger('scroll');
}
JSCODE;

$content .= "
floatingToolbar{$renderCount}('{$toolbarId}', '{$floatingPos}', '{$floatingOffset}');
</script>
";