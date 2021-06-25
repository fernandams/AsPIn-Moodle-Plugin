<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir.'/gradelib.php');

function get_quiz_name($selected_quiz) {
    global $DB;
    
    if (!empty($selected_quiz)) {
        $sql_query = 'select name from mdl_quiz where id = ' . $selected_quiz . ';';
        $query_result = $DB->get_record_sql($sql_query);   
        
        return $query_result->name;
    } else {
        return null;
    }
}

function get_quiz_module_id($selected_quiz) {
    global $DB, $COURSE;
    
    if (!empty($selected_quiz)) {
        $sql_query = 'select id from mdl_course_modules where course = ' . $COURSE->id . ' and module = 16 and instance = ' . $selected_quiz . ';';
        $query_result = $DB->get_record_sql($sql_query);   
       
        return $query_result->id;
    } else {
        return null;
    }
}

function get_section_number($selected_section) {
    global $DB, $COURSE;
    
    if (!empty($selected_section)) {
        $sql_query = 'select section from mdl_course_sections where id = ' . $selected_section . ';';
        $query_result = $DB->get_record_sql($sql_query);   
       
        return $query_result->section;
    } else {
        return null;
    }
}

function get_timeclose_quiz($quiz_id) {
    global $COURSE, $DB;

    $sql_query = 'select timeclose from mdl_quiz where course = ' . $COURSE->id . ' and id = ' . $quiz_id . ';';
    $query_result = $DB->get_record_sql($sql_query);
    return $query_result->timeclose;
}

function get_user_grade($quiz_id) {
    global $USER, $COURSE;

    if (!empty($quiz_id)) {

        $user_id = $USER->id;
        $user_name = $USER->username;
        $course_id = $COURSE->id;

        $grading_info = grade_get_grades($course_id, 'mod', 'quiz', $quiz_id, $user_id);
 
        $user_grade = $grading_info->items[0]->grades[$user_id]->grade;
        
        return $user_grade;   
    } else {
        return null;
    }
}

function get_quiz_options(){
    global $COURSE, $DB;

    $sql_query = 'select id, name from mdl_quiz where course =' . $COURSE->id . ';';
    $query_result = $DB->get_records_sql($sql_query);

    return $query_result;
}

function get_section_options(){
    global $COURSE, $DB;
    
    $sql_query = 'select id, name from mdl_course_sections where course =' . $COURSE->id . ';';
    $query_result = $DB->get_records_sql($sql_query);

    return $query_result;
}

function set_stealth_module($mod_id) {
    global $DB, $COURSE, $CFG;

    $CFG->allowstealth = 1;
    $DB->set_field('course_modules', 'visibleoncoursepage', 0, ['id' => $mod_id]);
    rebuild_course_cache($COURSE->id, true);
}

function set_grade_condition_availability($mod_id, $quiz_id) {
    global $DB, $COURSE; 
    
    $sql_query = 'select id from mdl_grade_items where iteminstance = ' . $quiz_id . ';';
    $query_result = $DB->get_record_sql($sql_query);
    $item_id = $query_result->id;

        // verificar se o aluno respondeu p form de percepção
        //      se não tiver nota ou nota == 0, esconder a seção
        //      se tiver tirado pelo menos 1, mostrar a seção
    $restriction = '{"op":"&","c":[{"type":"grade","id":' . $item_id . ',"min":25}],"showc":[false]}';
   
    $DB->set_field('course_sections', 'availability', $restriction, ['id' => $mod_id]);
    rebuild_course_cache($COURSE->id, true);
}