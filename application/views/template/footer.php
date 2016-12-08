
   <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/static/js/jquery.min.js"></script>
    <script src="/static/js/bootstrap.min.js"></script>
    <script src="/static/js/jquery.form.js"></script>
    <script src="/static/js/bootstrap-datetimepicker.min.js"></script>
    <script src="/static/js/bootstrap-datetimepicker.zh-CN.js"></script>
    <script src="/static/js/hrms.js"></script>

<?php if(!(isset($noNavbar) && $noNavbar==TRUE)): ?>
<hr>
<p> Copyright &copy; ChenBingjin 2016 
<span class="pull-right text-muted">
<?php
$this->benchmark->mark('code_end');
echo $this->benchmark->elapsed_time('code_start','code_end')."s ";
echo $this->benchmark->memory_usage();
?>
</span>
</p>
<?php 
 endif;?>
  </body>
</html>
