
<div class="row">
  <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#{{ $field['name'] }}">
     <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#{{ $field['name'] }}">
        <div class="btn-group">
           <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
           <ul class="dropdown-menu">
           </ul>
        </div>
        <div class="btn-group">
           <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
           <ul class="dropdown-menu">
              <li>
                 <a data-edit="fontSize 5">
                    <p style="font-size:17px">Huge</p>
                 </a>
              </li>
              <li>
                 <a data-edit="fontSize 3">
                    <p style="font-size:14px">Normal</p>
                 </a>
              </li>
              <li>
                 <a data-edit="fontSize 1">
                    <p style="font-size:11px">Small</p>
                 </a>
              </li>
           </ul>
        </div>
        <div class="btn-group">
           <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
           <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
           <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
           <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
        </div>
        <div class="btn-group">
           <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
           <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
           <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
           <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
        </div>
        <div class="btn-group">
           <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
           <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
           <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
           <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
        </div>
        <div class="btn-group">
           <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
           <div class="dropdown-menu input-append">
              <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
              <button class="btn" type="button">Add</button>
           </div>
           <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
        </div>
        <div class="btn-group">
           <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
           <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
        </div>
        <div class="btn-group">
           <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
           <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
        </div>
     </div>
     <div id="{{ $field['name'] }}" class="editor-wrapper">{!! $value !!}</div>

     {{ \Form::textarea($field['name'], $value, ['class' => 'resizable_textarea form-control', 'style' => 'display: none;']) }}
  </div>
</div>
<!-- bootstrap-wysiwyg -->
<script>
  addLoadEvent(function() {
    function initToolbarBootstrapBindings() {
      var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
        'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
        'Times New Roman', 'Verdana'
      ];

      var fontTarget = $('[title=Font]').siblings('.dropdown-menu');
      // Setup fonts menu
      $.each(fonts, function(idx, fontName) {
        fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
      });

      // position tooltips
      $('a[title]').tooltip({
        container: 'body'
      });

      // initialise dropdown menus
      $('.dropdown-menu input').click(function() {
        return false;
      }).change(function() {
        $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
      }).keydown('esc', function() {
        this.value = '';
        $(this).change();
      });

      $('[data-role=magic-overlay]').each(function() {
        var overlay = $(this),
        target = $(overlay.data('target'));
        overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
      });

      // Speech accessibility
      if ("onwebkitspeechchange" in document.createElement("input")) {
        var editorOffset = $('#{{ $field['name'] }}').offset();

        $('.voiceBtn').css('position', 'absolute').offset({
          top: editorOffset.top,
          left: editorOffset.left + $('#{{ $field['name'] }}').innerWidth() - 35
        });
      } else {
        $('.voiceBtn').hide();
      }
    }

    function showErrorAlert(reason, detail) {
      var msg = '';
      if (reason === 'unsupported-file-type') {
        msg = "Unsupported format " + detail;
      } else {
        console.log("error uploading file", reason, detail);
      }
      $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
        '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
    }

    initToolbarBootstrapBindings();

    $('#{{ $field['name'] }}').wysiwyg({
      fileUploadError: showErrorAlert
    });


    // window.prettyPrint;
    // prettyPrint();

    // $('#{{$field['name']}}').html($('[name="{{ $field['name'] }}"]').html());


    // Keep input content in sync with editor preview
    $('#{{$field['name']}}').wysiwyg().on('change', function()
      {
        $('[name="{{ $field['name'] }}"]').html($('#{{$field['name']}}').html());
      });
   });
</script>
<!-- /bootstrap-wysiwyg -->