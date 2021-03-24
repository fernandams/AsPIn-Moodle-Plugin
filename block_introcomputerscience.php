<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir.'/gradelib.php');

class block_introcomputerscience extends block_base {
    public function init() {
        $this->title = get_string('introcomputerscience', 'block_introcomputerscience');
    }

    public function get_user_grade() {
        global $USER, $COURSE;

        $user_id = $USER->id;
        $user_name = $USER->username;
        $course_id = $COURSE->id;

        //$users == array of users
        $grading_info = grade_get_grades($course_id, 'mod', 'quiz', 4, $user_id);
 
        return " Id: " . $user_id . "\nNome: " . $user_name . " Nota: " . $grading_info->items[0]->grades[$user_id]->str_grade;
    }
   
    public function get_content() {
        if ($this->content !== null) {
          return $this->content;
        }
     
        $this->content         =  new stdClass;
        if (! empty($this->config->content_text)) {
            $this->content->text = $this->config->content_text;
        }else{
            $this->content->text   = 'The content of our introcomputerscience block!';
        }
     
        $this->content->footer = $this->get_user_grade();

        return $this->content;

    }
}