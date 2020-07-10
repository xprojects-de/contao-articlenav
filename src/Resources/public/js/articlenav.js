$(document).ready(function () {
  var xfoundItem = false;
  $('a.xarticlenavitem').each(function () {
    if (xfoundItem === false) {
      xfoundItem = true;
      $(this).addClass("xactive");
    }
    $($(this)).click(function (event) {
      $('a.xarticlenavitem').each(function () {
        $(this).removeClass("xactive");
      });
      $(this).addClass("xactive");
      var targetID = $(this).attr("data-id");
      if ($('#' + targetID).length > 0) {
        $('body, html').animate({scrollTop: $('#' + targetID).offset().top - 105}, 600);
      } else {
        window.location.href = $(this).attr("href");
      }
      event.preventDefault();
    });
  });

});


