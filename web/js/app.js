var formManager = {
    'init': function init() {
        var self = this;
        var $collectionHolder = $('#pizza_ingredients');
        var sortedItems = $collectionHolder.sortable();
        var $addIngredientLink = $('<a href="#" class="add_ingredient_link">Add an ingredient</a>');
        var $newLinkLi = $('<li></li>').append($addIngredientLink);
        
        $collectionHolder.find('div.ui-sortable-handle').each(function() {
            self.addDeleteLink($(this));
        });

        $collectionHolder.append($newLinkLi);

        $collectionHolder.data('index', $collectionHolder.find(':input').length);
        $addIngredientLink.on('click', function(e) {
            e.preventDefault();
            self.addIngredientForm($collectionHolder, $newLinkLi);
        });
    },
    'addIngredientForm': function addIngredientForm($collectionHolder, $newLinkLi) {
        var prototype = $collectionHolder.data('prototype');
        var index = $collectionHolder.data('index');
        var newForm = prototype.replace(/__name__/g, index);
        $collectionHolder.data('index', index + 1);
    
        var $newFormBlock = $('<div></div>').append(newForm);
        $newLinkLi.before($newFormBlock);
    },
    'addDeleteLink': function addDeleteLink($form) {
        var $removeLink = $('<a href="#">delete this ingredient</a>');
        $form.append($removeLink);
        
        $removeLink.on('click', function(e) {
            e.preventDefault();
            $form.remove();
    });
    }
};