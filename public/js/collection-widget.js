function collectionAdd(addButton, collection) {
    $(addButton).on('click', function (event) {
        var collectionHolder = $(collection);
        
        var counter = $(collection).data('widget-counter') | $(collection).children().length;
        
        var prototype = collectionHolder.attr('data-prototype');
        var form = prototype.replace(/__name__label__/g, counter);
        var form = form.replace(/__name__/g, counter);
        
        counter++;
        $(collection).data('widget-counter', counter);        

        collectionHolder.append($('<textarea />').html(form).text());
    });
}
function collectionRemove() {
    $('body').on('click', '.remove-collection', function (event) {
        $(this).parents('div').first().remove();
    });
}


