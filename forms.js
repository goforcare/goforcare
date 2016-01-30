(function ($) {
  $(document).ready(function() {
/**************************
     * Auto complete plugin  *
     *************************/
    $(input_selector).each(function() {
      var $input = $(this);

        if( $input.hasClass('autocomplete') ) {
          var $array = $input.data('array'),
              $inputDiv = $input.closest('.input-field'); // Div to append on

          // Check if "data-array" isn't empty
          if( $array !== '' ) {
            // Create html element
            var $html = '<ul class="autocomplete-content hide">';

            for( var i = 0; i < $array.length; i++ ) {
              // If path and class aren't empty add image to auto complete else create normal element
              if( $array[i]['path'] !== '' && $array[i]['class'] !== '' ) {
                $html += '<li class="autocomplete-option"><img src="'+$array[i]['path']+'" class="'+$array[i]['class']+'"><span>'+$array[i]['value']+'</span></li>';
              } else {
                $html += '<li class="autocomplete-option"><span>'+$array[i]['value']+'</span></li>';
              }
            }

            $html += '</ul>';
            $inputDiv.append($html); // Set ul in body
            // End create html element

            function highlight(string) {
              $('.autocomplete-content li').each(function () {
                var matchStart = $(this).text().toLowerCase().indexOf("" + string.toLowerCase() + ""),
                    matchEnd = matchStart + string.length - 1,
                    beforeMatch = $(this).text().slice(0, matchStart),
                    matchText = $(this).text().slice(matchStart, matchEnd + 1),
                    afterMatch = $(this).text().slice(matchEnd + 1);
                $(this).html("<span>" + beforeMatch + "<span class='highlight'>" + matchText + "</span>" + afterMatch + "</span>");
              });
            }

            // Perform search
            $(document).on('keyup', $input, function () {
              var $val = $input.val().trim(),
                  $select = $('.autocomplete-content');
              // Check if the input isn't empty
              if ($val != '') {
                $select.children('li').addClass('hide');
                $select.children('li').filter(function() {
                  $select.removeClass('hide'); // Show results

                  // If text needs to highlighted
                  if( $input.hasClass('highlight-matching') ) {
                    highlight($val);
                  }

                  return $(this).text().indexOf($val) !== -1;
                }).removeClass('hide');
              } else {
                $select.children().addClass('hide');
              }
            });

            // Set input value
            $('.autocomplete-option').click(function() {
              $input.val($(this).text().trim());
            });
          } else {
            return false;
          }
        }
      });

  }); // End of $(document).ready
}( jQuery ));