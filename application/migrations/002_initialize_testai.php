<?php
/**
 * Created by PhpStorm.
 * User: arash
 * Date: 12/7/2018
 * Time: 1:52 PM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Initialize_testai extends CI_Migration {

    public function up()
    {
        //table structure for quiz
        $this->dbforge->add_field(array(
            'quiz_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'max_score' => array(
                'constraint' => 4,
                'type' => 'int',
            ),
            'max_time' => array(
                'type' => 'int',
            ),
            'max_attempt' => array(
                'type' => 'int',
            ),
            'question_number' => array(
                'constraint' => 4,
                'type' => 'int',
            ),
            'random_question' => array(
                'type' => 'bool',
            ),
            'random_answer' => array(
                'type' => 'bool',
            ),
            'creator_id' => array(
                'type' => 'int',
            ),
            'time_created' => array(
                'type' => 'datetime',
            ),
        ));
        $this->dbforge->add_key('quiz_id', TRUE);
        $this->dbforge->create_table('quiz');

        //table structure for user quiz
        $this->dbforge->add_field(array(
            'user_quiz_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'int',
            ),
            'quiz_id' => array(
                'type' => 'int',
            ),
            'quiz_grade' => array(
                'constraint' => 4,
                'type' => 'int',
                'null' => TRUE,
            ),
            'quiz_correct' => array(
                'constraint' => 4,
                'type' => 'int',
                'null' => TRUE,
            ),
            'quiz_false' => array(
                'constraint' => 4,
                'type' => 'int',
                'null' => TRUE,
            ),
            'quiz_start' => array(
                'type' => 'datetime',
            ),
            'quiz_end' => array(
                'type' => 'datetime',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('user_quiz_id', TRUE);
        $this->dbforge->create_table('user_quiz');

        //table structure for user_quiz_answer
        $this->dbforge->add_field(array(
            'user_quiz_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'question_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'answer_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => TRUE,
            ),
            'answer_time' => array(
                'type' => 'datetime',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('user_quiz_id', TRUE);
        $this->dbforge->add_key('question_id', TRUE);
        $this->dbforge->create_table('user_quiz_answer');

        //table structure for question
        $this->dbforge->add_field(array(
            'question_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'question_type' => array(
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => TRUE
            ),
            'question_level' => array(
                'type' => 'INT',
                'constraint' => 2,
                'unsigned' => TRUE
            ),
            'question' => array(
                'type' => 'TEXT'
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
            'creator_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'default' => 1
            ),
            'time_created' => array(
                'type' => 'datetime',
            ),
        ));
        $this->dbforge->add_key('question_id', TRUE);
        $this->dbforge->create_table('question');

        //table structure for answer
        $this->dbforge->add_field(array(
            'answer_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'question_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'answer' => array(
                'type' => 'TEXT'
            ),
            'correct' => array(
                'type' => 'bool',
            ),
            'score' => array(
                'type' => 'INT',
            ),
        ));
        $this->dbforge->add_key('answer_id', TRUE);
        $this->dbforge->create_table('answer');

        //table structure for quiz_question
        $this->dbforge->add_field(array(
            'quiz_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'question_id' => array(
                'type' => 'INT',
                'unsigned' => TRUE
            ),
            'question_order' => array(
                'type' => 'INT',
                'unsigned' => TRUE,
                'null' => TRUE
            ),
        ));
        $this->dbforge->add_key('quiz_id', TRUE);
        $this->dbforge->add_key('question_id', TRUE);
        $this->dbforge->create_table('quiz_question');

    }

    public function down()
    {
        $this->dbforge->drop_table('quiz');
        $this->dbforge->drop_table('question');
        $this->dbforge->drop_table('answer');
        $this->dbforge->drop_table('user_quiz');
        $this->dbforge->drop_table('user_quiz_answer');
        $this->dbforge->drop_table('quiz_question');
    }
}