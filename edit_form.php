<?php

require_once(dirname(__FILE__) . '/../../config.php');

class block_introcomputerscience_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
        global $DB, $COURSE;

        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
 
        $sql_query = 'select id, name from mdl_quiz where course =' . $COURSE->id . ';';
        $query_result = $DB->get_records_sql($sql_query);
        $options = [];
        foreach ($query_result as $record) {
           $options[$record->id] = $record->name;
        }
        $select = $mform->addElement('select', 'config_selected_quiz', get_string('config_quiz', 'block_introcomputerscience'), $options);
        $select->setSelected('3');
         
    }
}