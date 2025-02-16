$(function(){
  
  var app = new App();
  app.init();

  hideAlert();
  $.nette.ext('snippets').after(function () {
    hideAlert();
  });
});

function hideAlert() {
  setTimeout(() => {
    $(".alert").fadeOut();
  }, 6500);
}