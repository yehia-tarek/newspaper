    <div class="footer"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      
        $('input[type="checkbox"]').change(function(e) {

var checked = $(this).prop("checked"),
    container = $(this).parent(),
    siblings = container.siblings();

container.find('input[type="checkbox"]').prop({
  indeterminate: false,
  checked: checked
});

function checkSiblings(el) {

  var parent = el.parent().parent(),
      all = true;

  el.siblings().each(function() {
    let returnValue = all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
    return returnValue;
  });
  
  if (all && checked) {

    parent.children('input[type="checkbox"]').prop({
      indeterminate: false,
      checked: checked
    });

    checkSiblings(parent);

  } else if (all && !checked) {

    parent.children('input[type="checkbox"]').prop("checked", checked);
    parent.children('input[type="checkbox"]').prop("indeterminate", (parent.find('input[type="checkbox"]:checked').length > 0));
    checkSiblings(parent);

  } else {

    el.parents("li").children('input[type="checkbox"]').prop({
      indeterminate: true,
      checked: false
    });

  }

}

checkSiblings(container);
});
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
  </body>
</html>