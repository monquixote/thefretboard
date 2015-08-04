<?php

$attachments = $this->Data('_attachments');
$editorkey = $this->Data('_editorkey');

?>

<div class="editor-upload-saved editor-upload-readonly" id="editor-uploads-<?php echo $editorkey; ?>">

   <?php foreach ($attachments as $attachment): ?>

      <?php

         $isOwner = (Gdn::Session()->IsValid() && (Gdn::Session()->UserID == $attachment['InsertUserID']));
         $viewerCssClass = ($isOwner)
            ? 'file-owner'
            : 'file-readonly';
         if (Gdn::Session()->CheckPermission('Garden.Moderation.Manage')) {
            $viewerCssClass = 'file-owner';
         }
         if (val('InBody', $attachment)) {
            $viewerCssClass .= ' in-body';
         }

         $pathParse = Gdn_Upload::Parse($attachment['Path']);
         $thumbPathParse = Gdn_Upload::Parse($attachment['ThumbPath']);

         $filePreviewCss = ($attachment['ThumbPath'])
            ? '<i class="file-preview img" style="background-image: url('. $thumbPathParse['Url'] .')"></i>'
            : '<i class="file-preview icon icon-file"></i>';
      ?>

      <div class="editor-file-preview <?php echo $viewerCssClass; ?>" id="media-id-<?php echo $attachment['MediaID']; ?>" title="<?php echo htmlspecialchars($attachment['Name']); ?>">
         <input type="hidden" name="MediaIDs[]" value="<?php echo $attachment['MediaID']; ?>" disabled="disabled" />
         <?php echo $filePreviewCss; ?>
         <div class="file-data">
         <a class="filename" data-type="<?php echo $attachment['Type']; ?>" data-width="<?php echo $attachment['ImageWidth']; ?>" data-height="<?php echo $attachment['ImageHeight']; ?>" href="<?php echo $pathParse['Url'] ?>" target="_blank"><?php echo htmlspecialchars($attachment['Name']); ?></a>
         <span class="meta"><?php echo Gdn_Format::Bytes($attachment['Size'], 1); ?></span>
         </div>
         <span class="editor-file-remove" title="<?php echo T('Remove'); ?>"></span>
         <span class="editor-file-reattach" title="<?php echo T('Click to re-attach'); ?>"></span>
      </div>

   <?php endforeach; ?>

</div>
