$(document).ready(function(){
    $('#submitBtn').click(function(){
        var presetValue = $('#presetDropdown').val();
        var ajaxurl = '/homepage',
        data =  {'action': presetValue};
        $.post(ajaxurl, data, function (response) {
            // Response div goes here.
            alert(response);
        });
    });

});

function showDropdown() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}


