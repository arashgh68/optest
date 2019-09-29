<div class="container">
    <div class="row">
        <div class="col-md-6">
            <br>
        </div>
        <div class="col-md-6"><!-- search box
            <div class="input-group mb-3">
                <input id="query" type="text" class="form-control search-input">
                <button id="search" class="btn btn-success">جست و جو</button>
            </div>-->
        </div>
    </div>
</div>
<div class="loader">
    <h4>
        <img src="<?php echo base_url('/image').'/loading.gif';?>" style="vertical-align:middle" /><br />
        در حال بارگذاری
    </h4>
</div>
<div id="answer_sheet">
    <table>
        <tbody>
            <?php $rown=1;
            foreach ($answer_sheet as $row) {
               // echo $row['answer_count'].'<br>';
                ?>
            <tr id="<?php echo $row['question_id'];?>">
                <?php
                echo '<td>'.$rown.'.</td>';
                for($i=1;$i<=4;$i++) {
                    switch($i) {
                        case $row['user_option_num']:
                            if ($i == $row['correct_option_num']) {
                                echo '<td class="user_correct_answer" style="color: #00CC00">&#10004;</td>';
                            } else {
                                echo '<td class="wrong_user_answer" style="color:darkred">&#x2716;</td>';
                            }
                            break;
                        case $row['correct_option_num']:
                            if ($i == $row['user_option_num']) {
                                echo '<td class="user_correct_answer" style="color: #00CC00">&#10004;</td>';
                            } else {
                                echo '<td class="correct-question-answer" style="color:red">&#10004;</td>';
                            }
                            break;
                        default:
                            echo '<td>&#9711;</td>';
                            break;
                    }
                }
                ?>
            </tr>
            <?php $rown++;}?>
        </tbody>
    </table>
</div>

