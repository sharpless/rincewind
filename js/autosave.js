jQuery(document).ready(function() {
  $("#postform").ajaxForm({
    dataType: 'json',
    beforeSubmit: function() {
      autosave.callbackBeforeSave(); // Disable buttons
    },
    success: function(data, status) { // Update form data if save is successful
      $('#tid').val(data.tid);
      $('#pid').val(data.pid);
      //alert('Saved: ' + status + ', tid: ' + data.tid + ', pid: ' + data.pid);
    }
  });
  var autosave = {
    // Set up autosave variables, time in ms
    time: 5000,
    id: null,
    callbackSave: function() {
      $("#postform").submit();
    },
    callbackBeforeSave: function() {
      $("#save").attr("disabled", "disabled");
      $("#save").css("display", "inline");
      clearTimeout(autosave.id);
      $('#postform').bind('keyup', autosave.callbackDetect);
    },
    callbackDetect: function(event){
      $('#postform').unbind('keyup');
      $("#save").removeAttr('disabled');
      if($("#topic").val() && !(!$("#content").val() || $("#content").val() == "<p></p>")) {
        // If the fields aren't empty, enable publish.
        $("#publish").removeAttr('disabled');
      }
      autosave.id = setTimeout(autosave.callbackSave, autosave.time);
    }
  }
  autosave.callbackBeforeSave();
  $("#publish").attr("disabled", "disabled")
  $("#postform").bind('keyup', autosave.callbackDetect);
  $("#postform").click(function(event) {
    if($(event.target).is('#publish')) {
      // If button "publish" is clicked, show link to post
      $('#published').css('visibility', 'visible');
      $('#published').attr('href', "?m=atuin&p=showthread&tid=" + $('#tid').val() + '#pid' + $("#pid").val());
    }
  });
});

