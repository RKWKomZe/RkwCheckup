
/* TAB JS */
function openTab(evt, tabName) {
  // Declare all variables
  var i, tabcontent, tablinks;
  var tabContentName = 'content-' + tabName;

  // Get all elements with class="tabcontent" and hide them
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }

  // Get all elements with class="tablinks" and remove the class "active"
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }

  // Show the current tab, and add an "active" class to the button that opened the tab
  document.getElementById(tabContentName).style.display = "block";
  evt.currentTarget.className += " active";
}


document.addEventListener("DOMContentLoaded", function(event) {


    /* ACCORDION JS */
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
          /* Toggle between adding and removing the "active" class,
          to highlight the button that controls the panel */
          this.classList.toggle("active");

          var targetPanel = 'panel-' + this.id;
          if (document.getElementById(targetPanel).style.display === "block") {
              document.getElementById(targetPanel).style.display = "none";
          } else {
              document.getElementById(targetPanel).style.display = "block";
          }
        });
    }

});
