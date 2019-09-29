<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Modify_category extends CI_Migration
{

    public function up()
    {
        $this->dbforge->add_column('category', array(
            'parent' => array(
                'type' => 'int'
            )
        ));

        $this->dbforge->drop_column('answer', 'score');
        $this->dbforge->add_column('answer', array(
            'score' => array(
                'type' => 'int',
                'default' => 1
            )
        ));
    }

    public function down()
    {
        $this->dbforge->drop_column('category', 'parent');
        $this->dbforge->drop_column('answer', 'score');
        $this->dbforge->add_column('answer', array(
            'score' => array(
                'type' => 'int'
            )
        ));
    }
}