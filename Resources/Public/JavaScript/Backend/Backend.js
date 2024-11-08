
/* TAB JS */

/*
IMPORTANT: DO NOT WORK INITIAL WITH "display: none", BECAUSE GOOGLE GRAPH DOES NOT WORK WELL WITH THIS PROPERTY
 */


function openTab(evt, tabName) {
      // Declare all variables
      var i, tabcontent, tablinks;
      var tabContentName = 'content-' + tabName;

      // Get all elements with class="tabcontent" and hide them
      tabcontent = document.getElementsByClassName("tabcontent");
      for (i = 0; i < tabcontent.length; i++) {
            //tabcontent[i].style.display = "none";
            tabcontent[i].style.visibility = "hidden";
            tabcontent[i].style.height = 0;
            tabcontent[i].style.border = 'none';
      }

      // Get all elements with class="tablinks" and remove the class "active"
      tablinks = document.getElementsByClassName("tablinks");
      for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
      }

      // Show the current tab, and add an "active" class to the button that opened the tab
      //document.getElementById(tabContentName).style.display = "block";
      document.getElementById(tabContentName).style.visibility = "visible";
      document.getElementById(tabContentName).style.height = '100%';
      document.getElementById(tabContentName).style.border = '1px solid #ccc';
      evt.currentTarget.className += " active";
}


document.addEventListener("DOMContentLoaded", function(event) {

    /* initial: hide TABS */
    var i, tabcontent;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
        if (i > 0) {
            // tabcontent[i].style.display = "none";
            tabcontent[i].style.visibility = "hidden";
        }

    }

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

    // Toggle accordions
    var acc = document.getElementsByClassName("toggle-accordions");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            /* Toggle between adding and removing the "active" class,
            to highlight the button that controls the panel */
            this.classList.toggle("active");

            // ID of toggle button is the same as the class name of the singel panels
            var toggleButtonId = this.getAttribute('id');

            var toggleButtonIsActive = this.classList.contains('active');

            // toggle "active" for accordion-header
            document.querySelectorAll('.accordion-' + toggleButtonId).forEach(function(el) {
                if (toggleButtonIsActive) {
                    el.classList.remove('active');
                } else {
                    el.classList.add('active');
                }
            });

            // toggle accordion-panels
            document.querySelectorAll('.' + toggleButtonId).forEach(function(el) {
                if (toggleButtonIsActive) {
                    el.style.display = 'none';
                } else {
                    el.style.display = 'block';
                }
            });

        });
    }

});
