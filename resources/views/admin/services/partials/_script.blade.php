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
                $(node).find('.showValue').html(value);
                updatedExisting = true;
            }
        });

        if (!updatedExisting) {
            var $li = $('<li><div class="col-md-3 col-md-offset-4 showKey"></div><div class="col-md-2 showValue"></div><div class="col-md-2 showButton"></div><div class="clearfix"></div></li>');
            var $key = $('<input>').addClass('keyField').attr('type', 'hidden').val(key);
            var $value = $('<input>').addClass('valueField').attr('type', 'hidden').val(value);
            var $button = $('<button>').text('Remove').addClass('btn btn-danger btn-sm').click(function (evt) {
                evt.preventDefault();
                removeItem(evt.target);
            });
            $li.prepend($key);
            $li.prepend($value);
            $li.find('.showKey').html(key);
            $li.find('.showValue').html(value);
            $li.find('.showButton').append($button);
            $collection.append($li);
        }

        sortInputs();
    }

    function sortInputs() {
        $.each(['query', 'headers'], function (index, value) {
            $('ul#' + value).find('li').each(function (innerIndex, node) {
                $(node).find('.keyField').attr('name', value + '[' + innerIndex + '][key]');
                $(node).find('.valueField').attr('name', value + '[' + innerIndex + '][value]');
            });
        });
    }

    function removeItem(node) {
        $(node).closest('li').remove();
        sortInputs();
    }
</script>