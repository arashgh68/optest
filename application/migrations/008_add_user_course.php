<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_User_Course extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_field(array(
            'user_course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),            
            'course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
        ));
        $this->dbforge->add_key('user_course_id', TRUE);
        $this->dbforge->create_table('user_course');
    }

    public function down()
    {
        $this->dbforge->drop_table('user_course');
    }
}