<script>
    function addHeader() {
        var key = $('#addHeaderKey').val();
        var value = $('#addHeaderValue').val();
        var name = 'headers';
        return addToCollection(key, value, name);
    }

    function addQuery() {
        var key = $('#addQueryKey').val();
        var value = $('#addQueryValue').val();
        var name = 'query';
        return addToCollection(key, value, name);
    }

    function addToCollection(key, value, name) {

        var $collection = $('ul#' + name);
        if (key == '' || value == '') {
            return null;
        }
        var updatedExisting = false;
        $collection.find('li').each(function (index, node) {
            if ($(node).find('.keyField').val() == key) {
                $(node).find('.valueField').val(value);
                $(node).find('.contentInfo').replaceWith(getContentField(key, value));
                updatedExisting = true;
            }
        });

        if (!updatedExisting) {
            var $li = $('<li>');
            var $key = $('<input>').addClass('keyField').attr('type', 'hidden').val(key);
            var $value = $('<input>').addClass('valueField').attr('type', 'hidden').val(value);
            var $button = $('<button>').text('Remove').addClass('btn').addClass('btn-danger').click(function(evt) {
                evt.preventDefault();
                removeItem(evt.target);
            });
            $li.append($key);
            $li.append($value);
            $li.append(getContentField(key, value));
            $li.append($button);
            $collection.append($li);
        }

        sortInputs();
    }

    function sortInputs() {
        $.each(['query', 'headers'], function (index, value) {
            $('ul#' + value).find('li').each(function (innerIndex, node) {
                $(node).find('.keyField').attr('name', 'headers[' + innerIndex + '][key]');
                $(node).find('.valueField').attr('name', 'headers[' + innerIndex + '][value]');
            });
        });
    }

    function getContentField(key, value) {
        return $('<span>').addClass('contentInfo').append('<strong>' + key + '</strong>: ' + value);
    }

    function removeItem(node) {
        $(node).closest('li').remove();
        sortInputs();
    }
</script>