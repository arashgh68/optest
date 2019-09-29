<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>
</main>
</div>
</div>
<!-- end container -->

<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>

<?php foreach ($scripts as $script){
    echo $script;
} ?>

</body>
</html>