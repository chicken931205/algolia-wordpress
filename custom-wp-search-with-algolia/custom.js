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
    // Show the advanced search options
    // $(".sel-search-advanced-show").on("click", function () {
    //   $(".sel-search-advanced").show();
    //   $(".sel-search-advanced-control").hide();
    //   // console.log("click");
    //   return false;
    // });
  
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
    
  
    $("div.hkb-article__link").each(function() {
      
      $(this).on('mousedown', function(event) {
        event.preventDefault();
      
        if (event.which === 2 || event.which === 1) { // Middle or Left mouse button 
            var hrefValue = $(this).attr('data_href');
            var postID = $(this).attr('data_post_id');
            var matched_results = [];
  
            var selector = '#post-' + postID + ' div.hkb-article__excerpt em.algolia-search-highlight';
            $(selector).each(function() {
              var text = $(this).text();
              if (matched_results.indexOf(text) === -1) {
                matched_results.push(text);
              }
            });
  
            if (matched_results.length !== 0) {
              var queryString = $.param({ matched_results: matched_results });
              hrefValue += '?' + queryString;
            }
  
            if (event.which === 1) {
              window.location.href = hrefValue;
            } else if (event.which === 2) {
              window.open(hrefValue, '_blank');
            }
  
        }
  
      });
  
    });
   
  });
  