
jQuery(document).ready(function ($) {
  // Show the advanced search options
  $(".sel-search-advanced-show").on("click", function () {
    $(".sel-search-advanced").show();
    $(".sel-search-advanced-control").hide();
    // console.log("click");
    return false;
  });

});
