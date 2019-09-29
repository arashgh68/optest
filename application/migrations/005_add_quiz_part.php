<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_quiz_part extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'part_quiz_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'part_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),            
            'quiz_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
        ));
        $this->dbforge->add_key('part_quiz_id', TRUE);
        $this->dbforge->create_table('part_quiz');
    }
    public function down()
    {
        $this->dbforge->drop_table('part_quiz');
    }
}