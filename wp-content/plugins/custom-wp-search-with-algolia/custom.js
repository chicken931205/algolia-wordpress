window.addEventListener('load', function() {
    document.querySelector('form.hkb-site-search').addEventListener('submit', function (event) {
      // Loop through all checkboxes
      const checkboxes = document.querySelectorAll('input[type="checkbox"]');
      
      checkboxes.forEach(function (checkbox) {
          if (checkbox.checked) {
              // Remove the hidden input with the same name if checkbox is checked
              const hiddenInput = checkbox.previousElementSibling;
              if (hiddenInput && hiddenInput.type === 'hidden' && hiddenInput.name === checkbox.name) {
                  hiddenInput.remove();
              }
          }
      });
    });
  });
  
  function getMatchedResults(paramName) {
    var urlParams = new URLSearchParams(window.location.search); // Get the query string
    var arrayValues = urlParams.getAll(paramName); // Get all values for the array
    return arrayValues;
  }
  
  jQuery(document).ready(function ($) {
  
    var highlight_matched_search_result = function(selector) {
      $(selector).each(function() {
  
        var text = $(this).text();
  
        matched_search_results.forEach(function(result) {
          const regex = new RegExp(result, 'gi');
          text = text.replace(regex, '<em class="algolia-search-highlight">' + result + '</em>');
        });
  
        $(this).html(text);
  
      });
    }
  
    var matched_search_results = getMatchedResults('matched_results[]');
    if ( matched_search_results.length !== 0 ) {
  
      highlight_matched_search_result("div.hkb-article__content p");
      highlight_matched_search_result("div.hkb-article__content h3");
      
    }

    var getHrefValue = function(selector) {
      var hrefValue = $(selector).attr('data_href');
      var postID = $(selector).attr('data_post_id');
      var matched_results = [];

      var highlight_selector = '#post-' + postID + ' div.hkb-article__excerpt em.algolia-search-highlight';
      $(highlight_selector).each(function() {
        var text = $(this).text();
        if (matched_results.indexOf(text) === -1) {
          matched_results.push(text);
        }
      });

      if (matched_results.length !== 0) {
        var queryString = $.param({ matched_results: matched_results });
        hrefValue += '?' + queryString;
      }

      return hrefValue;
    }
    
  
    $("a.hkb-article__link").each(function() {
      
      $(this).on('contextmenu', function(event) {
        // event.preventDefault();

        var hrefValue = getHrefValue($(this));

        $(this).attr('href', hrefValue);

        console.log('right click');
      });

      $(this).on('click', function(event) {
        $(this).removeAttr('href');
        event.preventDefault();

        var hrefValue = getHrefValue($(this));
        window.location.href = hrefValue;

        console.log('left click');
      });

      $(this).on('mousedown', function(event) {
        $(this).removeAttr('href');
        event.preventDefault();

        if (event.which === 2) {
          var hrefValue = getHrefValue($(this));
          window.open(hrefValue, '_blank');

          console.log('wheel click');
        }
      });

    });
   
  });
  