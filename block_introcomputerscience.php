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
 
        $user_grade = $grading_info->items[0]->grades[$user_id]->grade;

        if(empty($user_grade)){
            return "Parece que você ainda não respondeu o questionário!";
        }elseif($user_grade == 4){
            return "Id: " . $user_id . "\nNome: " . $user_name . "Nota: " . $grading_info->items[0]->grades[$user_id]->str_grade . "\nSiga o curso normalmente!";
        } elseif (( $user_grade == 2) || ($user_grade == 3)){

            return "Id: " . $user_id . "\nNome: " . $user_name . "Nota: " . $grading_info->items[0]->grades[$user_id]->str_grade . "\nRecomendamos que você faça a seção Básica!";

        } elseif (($user_grade == 0) || ($user_grade == 1)){

            return "Id: " . $user_id . "\nNome: " . $user_name . "Nota: " . $grading_info->items[0]->grades[$user_id]->str_grade . "\nRecomendamos que você faça a seção Introdutória!";
        }else{
            return "Parece que você ainda não respondeu o questionário!";
        }
    }
   
    public function get_content() {
        if ($this->content !== null) {
          return $this->content;
        }
     
        $this->content         =  new stdClass;
        if (! empty($this->config->content_text)) {
            $this->content->text = '<p>'. $this->config->content_text . '</p> <p>' . $this->get_user_grade() . '</p>' ;
        }else{
            $this->content->text   = '<p> The content of our introcomputerscience block! </p> <p>' . $this->get_user_grade() . '</p>' ;
        }

        return $this->content;

    }
}