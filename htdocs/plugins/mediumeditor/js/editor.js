;(function ($, window, document, undefined) {

  window.Editor = window.Editor || function (options) {
    this.options = {
      textarea: '.js-text-box'
    };

    if (options) {
      $.extend(this.options, options);
    }
  };

  Editor.prototype.attachEditor = function (textarea) {
    var $textarea = $(textarea);

    // If an editor is already attached, bail out
    if ($textarea.data('editor')) {
      return;
    }

    // Create an contentEditable element that we can attach the editor to
    var $contentEditable = $('<div class="editor js-editor"></div>');

    // Add the contentEditable element after the text box
    $textarea.after($contentEditable);

    var editor = new MediumEditor($contentEditable[0], {
      placeholder: 'Awaiting orders!'
    });

    // Load contents of the textarea into the contentEditable element
    $contentEditable.html($textarea.val());

    // If the contentEditable element isn't empty at this point, remove the
    // input placeholder
    if ($contentEditable.html()) {
      $contentEditable.removeClass('medium-editor-placeholder');
    }

    // Load contents of contentEditable element into the textarea on input
    $contentEditable.on('input', function () {
      $textarea.val($contentEditable.html());
    });

    // Initialize @mention autocompletion
    gdn.atCompleteInit($contentEditable);

    // Attach the editor to the textarea
    $textarea.data('editor', editor);

    // Attach contentEditable element to the textarea
    $textarea.data('contentEditable', $contentEditable);

    // Hide the original textarea
    $textarea.hide().addClass('Hidden');
  };

  Editor.prototype.attachEditorHandler = function () {
    var self = this;

    $(this.options.textarea).each(function () {
      self.attachEditor(this);
    });
  };

  Editor.prototype.clearEditor = function (textarea) {
    var $contentEditable = $(textarea).data('contentEditable');

    // Clear out the contents of the editor
    $contentEditable.empty();
  };

  Editor.prototype.clearEditorHandler = function (e) {
    var self = this;

    $(this.options.textarea, e.target).each(function () {
      self.clearEditor(this);
    });
  };

})(jQuery, window, document);
