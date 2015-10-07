<?php
$content = '
<script>
    function goToDynamicLink' . $renderCount . '(url, checkType, idName, containerId, errorMessage, confirmMessage) {

        if (typeof checkType == \'undefined\')
        checkType = \'single\';

        if (typeof idName == \'undefined\')
        idName = \'id\';

        if (typeof containerId == \'undefined\')
        containerId = \'container\';

        if (typeof errorMessage == \'undefined\')
        errorMessage = \'\';

        if (typeof confirmMessage == \'undefined\')
        confirmMessage = \'\';

        var container = document.getElementById(containerId);

        if (container) {
            var value = \'\';
            var values = \'\';
            var paramCount = 0;
            var inputs = container.getElementsByTagName(\'input\');

            if (inputs.length == 0) {
                alert(\'Error: No checkboxes were found in the HTML code.\');
                return;
            }

            for (var i = 0; i < inputs.length; i++) {
                if (inputs[i].type == "checkbox" && inputs[i].checked) {
                    values = values + \'&\' + idName + \'[]=\' + inputs[i].value;
                    value = \'&\' + idName + \'=\' + inputs[i].value;
                    paramCount++;
                }
            }

            if (confirmMessage != "") {
                if (!confirm(confirmMessage)) {
                    return;
                }
            }

            if (url.indexOf("?") == -1) {
                url = url + \'?\';

                if (value.indexOf("&") == 0) {
                    value = value.substring(1);
                }
                if (values.indexOf("&") == 0) {
                    values = values.substring(1);
                }
            }

            switch (checkType) {
                case \'single\':
                    if (paramCount == 1) {
                        location.href = url + value;
                    } else {
                        alert(errorMessage);
                    }
                    break;

                case \'multiple\':
                    if (paramCount > 0) {
                        location.href = url + values;
                    } else {
                        alert(errorMessage);
                    }
                    break;

                default:
                    return;
                    break;
            }
        } else {
            alert(\'Error: container not found\');
        }
    }
</script>
';