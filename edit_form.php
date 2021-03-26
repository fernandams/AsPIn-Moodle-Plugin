<?php

require_once(dirname(__FILE__) . '/../../config.php');

class block_introcomputerscience_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
        global $DB, $COURSE;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
 
        // A sample string variable with a default value.
        $mform->addElement('text', 'config_content_text', get_string('blockstring', 'block_introcomputerscience'));
        $mform->setDefault('config_content_text', 'Bem vindo ao curso!');
        $mform->setType('config_content_text', PARAM_RAW);   
        
        $sql_query = 'select id, name from mdl_quiz where course =' . $COURSE->id . ';';
        $query_result = $DB->get_records_sql($sql_query);
        $options = [];
        foreach ($query_result as $record){
           $options[$record->id] = $record->name;
        }
        $select = $mform->addElement('select', 'config_selected_quiz', get_string('config_quiz', 'block_introcomputerscience'), $options);
        $select->setSelected('3');
         
    }
}