/**
 * Tags Input Widget Constructor
 *
 * @param widget {string} the #id of the widget to tagify. If you wish to control
 * more than one widget at once, use a new TagsInput('.class'), where .class is
 * the class name of the target widgets.
 * @param autoBuild {boolean} By default, the constructor calls the factory to build the
 * widget. If you would rather invoke the factory manually, set autoBuild to false.
 * Note: If you would be defining options overrides via the setOptions method,
 * you must do that before calling the factory
 * @param options {object} Define constructor-based options override
 * @constructor
 */
function TagsInput(widget, autoBuild = true, options = {}) {
    this.widget = widget;
    this.fieldName = null;
    this.inputFromSuggestion = false;
    this.suggestionSourceUrl = '';
    this.isTagDeleteEnabled = true;
    this.tagsBordered = true;
    this.suggestionCallback = null;
    this.setOptions(options);
    if (autoBuild === true) {
        this.factory();
    }
}

TagsInput.prototype.classes = {
    tagClass: 'tags-input_tag',
    tagDeleteBtnClass: 'delete-tag',
    tagsWrapperClass: 'tags-input_tags',
    tagsContainerClass: 'tags-input_tags-container',
    tagsFieldClass: 'tags-input_field',
    tagsEditorClass: 'tags-input_editor',
    tagsWidgetClass: 'tags-input_widget',
    tagsSuggestionsContainerClass: 'tags-input_suggestions-container',
    tagsSuggestionsSuggestionClass: 'tags-input_suggestion',
};

TagsInput.prototype.elements = {
    tag: '<span class=""></span>',
    tagDeleteBtn: '<span class="">x</span>',
    tagsWrapper: '<div class=""></div>',
    tagsContainer: '<div class=""></div>',
    tagsInputField: '<input type="hidden" class="">',
    tagsInputEditor: '<input type="text" class="" placeholder="Start typing...">',
    tagsWidget: '<div class=""></div>',
    tagsSuggestionContainer: '<div></div>',
};

TagsInput.prototype.setElements = function (key, value = null) {
    if (typeof key === 'object') {
        let obj = this;
        Object.entries(key).forEach(function (entry, value) {
            if (obj.elements.hasOwnProperty(entry[0])) {
                obj.elements[entry[0]] = entry[1];
            }
        });
    } else if (typeof key === 'string' && typeof value !== 'null') {
        this.elements[key] = value;
    }
};

/**
 * Set overrides for the widget options. For options defined with this method
 * to take effect, it must be called immediately after the constructor, before
 * calling the tagify method.
 *
 * @param key
 * @param value
 */
TagsInput.prototype.setOptions = function (key, value = null) {
    if (typeof key === 'object') {
        let obj = this;
        Object.entries(key).forEach(function (entry, value) {
            if (obj.hasOwnProperty(entry[0])) {
                obj[entry[0]] = entry[1];
            }
        });
    } else if (typeof key === 'string' && typeof value !== null) {
        obj[key] = value;
    }
};

TagsInput.prototype.factory = function () {
    let p = this;
    // if ($(this.widget).length < 1) {
    //     $(this.widget).prepend(this.elements.tagsInputField);
    // }

    if (this.tagsBordered) {
        $(this.widget).addClass('tags-bordered');
    }

    if ($(this.widget).find('.' + this.classes.tagsFieldClass).length < 1) {
        let field = this.elements.tagsInputField || $('<input type="hidden" name="' + this.fieldName + '">');
        field = $(field).addClass(this.classes.tagsFieldClass);
        $(this.widget).prepend(field);
    }
    let tagsContainer = $(this.widget).find('.' + this.classes.tagsContainerClass);
    if (tagsContainer.length < 1) {
        tagsContainer = this.elements.tagsContainer || '<div></div>';
        tagsContainer = $(tagsContainer).addClass(this.classes.tagsContainerClass);
        $(tagsContainer).insertAfter($(this.widget).children(
            '.' + this.classes.tagsFieldClass
        ));
    }

    if ($(tagsContainer).find('input.' + this.classes.tagsEditorClass).length < 1) {
        let editor = this.elements.tagsInputEditor ||
            '<input type="text"' + ' class="' + this.classes.tagsEditorClass + '" placeholder="Start typing...">';
        if (!$(editor).hasClass(this.classes.tagsEditorClass)) {
            editor = $(editor).addClass(this.classes.tagsEditorClass);
        }
        $(tagsContainer).append(editor);
    }
    this.createTagButtons();
};

TagsInput.prototype.addTag = function (text = null) {
    let editor = $(this.widget).find('.' + this.classes.tagsEditorClass),
        field = $(this.widget).find('.' + this.classes.tagsFieldClass),
        fieldVal = field.val();

    if (text === null) {
        text = editor.val();
    }
    let fieldValList = fieldVal.split(',');
    text = text.rtrim(',').rtrim(';');
    if (fieldValList.indexOf(text) > 0) {
        return false;
    }
    fieldValList.push(text);
    fieldVal = fieldValList.join(',');
    field.attr('value', fieldVal);
    this.createTagButtons();
    editor.val('');
};

TagsInput.prototype.createTagButtons = function () {
    let obj = this;
    let container = $(obj.widget).find('.' + obj.classes.tagsContainerClass).eq(0);
    let field = $(obj.widget).find('.' + obj.classes.tagsFieldClass).eq(0);
    if ($(field).val().length < 1) {
        return false;
    }
    let tagsWrapper = $(container).find('.' + obj.classes.tagsWrapperClass);
    if (tagsWrapper.length < 1) {
        let wrapper = obj.elements.tagsWrapper || '<div></div>';
        wrapper = $(wrapper).addClass(obj.classes.tagsWrapperClass);
        container = $(container).prepend(wrapper);
        tagsWrapper = $(container).find('.' + obj.classes.tagsWrapperClass).eq(0);
    }
    let existingTags = field.attr('value').split(',');
    if (existingTags.length < 1) {
        return false;
    }
    $(tagsWrapper).html('');
    existingTags.forEach(function (item, index) {
        if (item !== null && item !== '' && item !== undefined && typeof item === 'string') {
            let tag = $(obj.elements.tag).html(item);
            tag = $(tag).attr({id: 'tag' + index, "data-index": index})
                .addClass(obj.classes.tagClass);
            if (obj.isTagDeleteEnabled) {
                let deleteBtn = $(obj.elements.tagDeleteBtn);
                deleteBtn = deleteBtn.addClass(obj.classes.tagDeleteBtnClass);
                $(tag).append(deleteBtn);
            }
            $(tagsWrapper).append(tag);
        }
    });
    $(container).prepend($(tagsWrapper));
};

TagsInput.prototype.offerSuggestions = function (input) {
    let obj = this;
    if (!obj.inputFromSuggestion || obj.suggestionSourceUrl == null) {
        return false;
    }
    let containerClass = obj.classes.tagsSuggestionsContainerClass,
        sugContainer = $(obj.widget).find('.' + containerClass);
    if (sugContainer.length < 1) {
        sugContainer = obj.elements.tagsSuggestionContainer ||
            '<div class="' + containerClass + '"></div>';

        if (!$(sugContainer).hasClass(containerClass)) {
            sugContainer = $(sugContainer).addClass(containerClass);
        }
        $(obj.widget).append(sugContainer);
        sugContainer = $(obj.widget).find('.' + containerClass);
    }

    if (input.length < 1) {
        sugContainer.html('');
        return false;
    }

    function buildSuggestions(data) {
        // let containerClass = obj.classes.tagsSuggestionsContainerClass,
        //     sugContainer = $(obj.widget).find('.' + containerClass);
        // if (sugContainer.length < 1) {
        //     sugContainer = obj.elements.tagsSuggestionContainer ||
        //         '<div class="' + containerClass + '"></div>';
        //
        //     if (!$(sugContainer).hasClass(containerClass)) {
        //         sugContainer = $(sugContainer).addClass(containerClass);
        //     }
        //     $(obj.widget).append(sugContainer);
        //     sugContainer = $(obj.widget).find('.' + containerClass);
        // }
        if (typeof obj.suggestionCallback === 'function') {
            obj.suggestionCallback(data, sugContainer, obj);
            // if (built === true) {
            //     // sugContainer
            // }
        }

        // dataObj = $.parseJSON(data);
        // console.log(dataObj);
        // Object.entries(dataObj).forEach(function (pair, index) {
        //     let suggestion = $('<span class="tag-input_suggestion"></span>');
        //     suggestion.html(pair[1]);
        //     sugContainer.append(suggestion);
        // });
    }

    let url = obj.suggestionSourceUrl;
    if (url.indexOf('?') > 0) {
        url += '&';
    } else {
        url += '?';
    }
    url += 'keyword=' + input + '&accepts=json';
    $.get({
        url: url,
        dataType: 'json',
        success: function (data, status) {
            return buildSuggestions(data);
        },
        error: function (data, status, xhrs) {

        }
    })
};

TagsInput.prototype.tagify = function () {
    let obj = this;
    /**
     * First prevent an accidental form submission with ENTER key
     */
    $(document).on('keydown', obj.widget + ' .' + obj.classes.tagsEditorClass, function (e) {
        if (e.keyCode === 13) {
            e.preventDefault();
        }
    });
    $(document).on('keyup', obj.widget + ' .' + obj.classes.tagsEditorClass, function (e) {
        
        let input = $(this).val();
        let field = $(obj.widget).find('.' + obj.classes.tagsFieldClass).eq(0);
        let existingTags = field.val();

        if (obj.inputFromSuggestion) {
            obj.offerSuggestions(input);
        } else if (input.endsWith(',') || input.endsWith(';') || e.keyCode === 13) {
            obj.addTag(input);
        }
    });

    $(document).on('click', obj.widget + ' .' + obj.classes.tagDeleteBtnClass, function () {
        obj.removeTag(this);
    });

    $(document).on('click', obj.widget + ' .' + obj.classes.tagsSuggestionsSuggestionClass, function () {
        if ($(this).hasClass('selected')) {
            return false;
        }
        let tag = $(this).data('tag-name');
        obj.addTag(tag);
        $(this).addClass('selected');
    });
};

TagsInput.prototype.removeTag = function (target) {
    let tag = $(target).parent(),
        index = tag.data('index');

    $(tag).remove();
    let existingTags = this.getExistingTags();
    if (existingTags.length < 1) {
        return false;
    }
    let tagName = existingTags[index];
    $(this.widget).find('#suggestion-' + tagName).removeClass('selected');
    existingTags[index] = null;
    this.updateField(existingTags).createTagButtons();

};

TagsInput.prototype.getExistingTags = function () {
    const field = $(this.widget).find('.' + this.classes.tagsFieldClass).eq(0);
    let fieldVal = $(field).attr('value');

    return fieldVal.split(',');
};

TagsInput.prototype.updateField = function (list) {
    let newList = [];
    list.forEach(function (item, pos) {
        if (item !== null && item !== '' && item !== undefined && typeof item === 'string') {
            newList.push(item);
        }
    });
    let fieldVal = newList.join(',');
    fieldVal.ltrim(',');
    $(this.widget).find('.' + this.classes.tagsFieldClass).eq(0)
        .attr('value', fieldVal);

    return this;
};

TagsInput.prototype.tagAlreadySelected = function (tag) {
    let existing = this.getExistingTags();

    return existing.includes(tag);
};
