<table class="table" style="text-align:right">
    <thead>
        <tr>
            <th scope='col'>عنوان آزمون</th>
            <th scope='col'>نام</th>
            <th scope="col">نام خانوادگی</th>
            <th scope="col">زمان شرع</th>
            <th scope="col">زمان پایان</th>
            <th scope='col'>نمره</th>
        </tr>
    </thead>
    <tbody>
        <?php
  $i = 1;
  foreach ($data as $row) {
      echo "<tr id= '".$row->user_quiz_id."'>";
      echo '<td>'.$row->title.'</td>';
      echo '<td>'.$row->first_name.'</td>';
      echo '<td>'.$row->last_name.'</td>';
      echo '<td>'.$row->quiz_start.'</td>';
      echo '<td>'.$row->quiz_end.'</td>';
      echo '<td>'.$row->quiz_grade.'</td>';
      echo '</tr>';
      ++$i;
  }
   ?>
    </tbody>
</table>



<script type="text/javascript">
$(".remove").click(function() {
    var id = $(this).parents("tr").attr("id");
    if (confirm('از حذف این کوییز اطمینان دارید؟')) {
        $.ajax({
            url: 'quizadmin/deleteqquiz/' + id,
            type: 'DELETE',
            error: function() {
                alert('Some error occured');
            },
            success: function(result) {
                if (result == true) {
                    $("#" + id).remove();
                    alert("با موفقیت حذف گردید");
                } else {
                    alert('این کوییز غیر قابل حذف می باشد');
                }
            }
        });
    }
});
</script>