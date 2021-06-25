<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/introcomputerscience/database_functions.php');

class block_introcomputerscience_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
        global $DB, $COURSE;

        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
 
        $quiz_options = [];
        foreach (get_quiz_options() as $record) {
           $quiz_options[$record->id] = $record->name;
        }
        $mform->addElement('select', 'config_selected_quiz', get_string('config_quiz', 'block_introcomputerscience'), $quiz_options);
        
        $mform->addElement('html', '<hr/>');

        $mform->addElement('html', '<p>' . get_string('config_instruction', 'block_introcomputerscience') . '</p> <br/>');

        $mform->addElement('select', 'config_list_1', get_string('config_list_1', 'block_introcomputerscience'), $quiz_options);
         
        $mform->addElement('select', 'config_list_2', get_string('config_list_2', 'block_introcomputerscience'), $quiz_options);
      
        $mform->addElement('select', 'config_list_3', get_string('config_list_3', 'block_introcomputerscience'), $quiz_options);
        
        $mform->addElement('select', 'config_list_4', get_string('config_list_4', 'block_introcomputerscience'), $quiz_options);
         
        $mform->addElement('select', 'config_list_5', get_string('config_list_5', 'block_introcomputerscience'), $quiz_options);

        $mform->addElement('select', 'config_list_6', get_string('config_list_6', 'block_introcomputerscience'), $quiz_options);
         
        $mform->addElement('select', 'config_list_7', get_string('config_list_7', 'block_introcomputerscience'), $quiz_options);

        $mform->addElement('html', '<hr/>'); 

        $mform->addElement('html', '<p>' . get_string('config_section_text', 'block_introcomputerscience') . '</p> <br/>');

        $section_options = [];
        foreach (get_section_options() as $record) {
           $section_options[$record->id] = $record->name;
        }

        $mform->addElement('select', 'config_section', get_string('config_section', 'block_introcomputerscience'), $section_options);
    }
}