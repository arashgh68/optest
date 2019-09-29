<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_tag_table extends CI_Migration {

    public function up()
    {
        //table structure for tag
        $this->dbforge->add_field(array(
            'parent_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'tag_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'tag_type' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'tag_importance' => array(
                'type' => 'datetime',
            ),
        ));
        $this->dbforge->add_key('parent_id', TRUE);
        $this->dbforge->add_key('tag_name', TRUE);
        $this->dbforge->add_key('tag_type', TRUE);
        $this->dbforge->create_table('tag');

        //table structure for category
        $this->dbforge->add_field(array(
            'category_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'description' => array(
                'type' => 'TEXT'
            ),
        ));
        $this->dbforge->add_key('category_id', TRUE);
        $this->dbforge->create_table('category');

        //table structure for course
        $this->dbforge->add_field(array(
            'course_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'description' => array(
                'type' => 'TEXT'
            ),
            'category_id' => array(
                'type' => 'INT',
            ),
        ));
        $this->dbforge->add_key('course_id', TRUE);
        $this->dbforge->create_table('course');

        //table structure for part of course
        $this->dbforge->add_field(array(
            'part_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'description' => array(
                'type' => 'TEXT'
            ),
            'course_id' => array(
                'type' => 'INT',
            ),
        ));
        $this->dbforge->add_key('part_id', TRUE);
        $this->dbforge->create_table('part');

    }

    public function down()
    {
        $this->dbforge->drop_table('tag');
        $this->dbforge->drop_table('category');
        $this->dbforge->drop_table('course');
        $this->dbforge->drop_table('part');
    }
}