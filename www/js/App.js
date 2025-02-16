function App() {


  this.init = function () {
    this.ajaxInit();
    this.bind();
  };

  this.ajaxInit = function () {
    $.nette.init();
  };

  this.bind = function () {
    $(document).on('click', 'button.confirm, a.confirm, .btn-danger:not(".no-confirm")', function (e) {
      var message = '';
      if ($(this).hasClass('delete')) {
        message = 'Do you really want to delete this item?';
      } else if ($(this).hasClass('edit')) {
        message = 'Do you really want to edit this item?';
      } else {
        message = $(this).data('message') || 'Are you sure?';
      }
      if (!confirm(message)) {
        return false;
        e.stopImmediatePropagation();
      }
    });    
  };

  this.rebind = function () {

  };

  this.isTouch = function () {

  };

}