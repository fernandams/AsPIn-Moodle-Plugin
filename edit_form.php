<?php
 
class block_introcomputerscience_edit_form extends block_edit_form {
 
    protected function specific_definition($mform) {
 
        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));
 
        // A sample string variable with a default value.
        $mform->addElement('text', 'config_content_text', get_string('blockstring', 'block_introcomputerscience'));
        $mform->setDefault('config_content_text', 'Bem vindo ao curso!');
        $mform->setType('config_content_text', PARAM_RAW);        
 
    }
}