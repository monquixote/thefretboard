 // // Copyright (c) 2013  Peregrine  see vanillaforums.org
 
   $(document).on("click", ".PeregrineClick",  function(e) { 
      var $elem = $(this);
      var $parent = $(this).closest('.Item');
      var $sibs = $elem.siblings().filter( $(".ReactionCount") )
      var href = $elem.attr('href');
      var progressClass = 'InProgress';
      if (!href)
         return;
      gdn.disable(this, progressClass);
      e.stopPropagation();
      
      $.ajax({
         type: "POST",
         url: href,
         data: { DeliveryType: 'VIEW', DeliveryMethod: 'JSON', TransientKey: gdn.definition('TransientKey') },
         dataType: 'json',
         complete: function() {
            gdn.enable(this);
            $elem.removeClass(progressClass);
            $elem.attr('href', href);
            
         },
         error: function(xhr) {
            gdn.informError(xhr);
         },
         success: function(json) {
            if (json == null) json = {};
          //  var reaction = json.val();
            var informed = gdn.inform(json);
            var on =  parseInt(json['on' ],10)-1;
            var off = parseInt(json['off'],10)-1;
            var $val = 1;
            $sibs.removeClass("MyReactClick");
           var which = ($parent.find(".ReactionCount"));
             which.each(function( index ) {
                  if ((index === (on)) ) {                                       
                        $val =  $(this).text();
                        $(this).text(parseInt($val,10)+1);
                        $(this).addClass("MyReactClick");
                       gdn.informMessage('Shazam', {'CssClass' : 'Dismissable AutoDismiss'});
                       };
                   if ((index === (off)) ) {                                       
                        $val =  $(this).text();
                        $(this).text(parseInt($val,10)-1);
                       };
                       // console.log( index + ": " + $(this).text() );
                  });
           gdn.inform(json);
         }
      });

      return false;   
   });

// $(document).on("click", ".PeregrineClick", PRClick);

   
  // $(document).delegate('.PeregrineClick', 'click', PRClick);
