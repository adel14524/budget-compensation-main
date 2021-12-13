
  <!-- Menu Toggle Script -->
  <?php
  include 'form.php';
  include 'ajaxconnector.php';
  include 'searchconnector.php';
  ?>
  <script>
    $("#menu-toggle").click(function(e) {
      e.preventDefault();
      $("#wrapper").toggleClass("toggled");
    });
  </script>
