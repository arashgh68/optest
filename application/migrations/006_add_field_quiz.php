<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_field_quiz extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('quiz', array(
            'demerit' => array(
                'type' => 'bool'
            ),
            //time to view answers
            'answer_date' => array(
                'type' => 'datetime'
            )
        ));

        $this->dbforge->modify_column('user_quiz', array(
            'quiz_grade' => array(
                'type' => 'float'
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('quiz', 'demerit');
        $this->dbforge->drop_column('quiz', 'answer_date');
        $this->dbforge->modify_column('user_quiz', array(
            'quiz_grade' => array(
                'type' => 'int'
            )
        ));
    }
}