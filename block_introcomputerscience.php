<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir.'/gradelib.php');


class block_introcomputerscience extends block_base {
    public function init() {
        $this->title = get_string('introcomputerscience', 'block_introcomputerscience');
    }

    public function get_user_grade($quiz_id) {
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
   
    public function get_quiz_module_id() {
        global $DB, $COURSE;
        
        if (!empty($this->config->selected_quiz)) {
            $selected_quiz = $this->config->selected_quiz;
            $sql_query = 'select id from mdl_course_modules where course = ' . $COURSE->id . ' and module = 16 and instance = ' . $selected_quiz . ';';
            $query_result = $DB->get_record_sql($sql_query);   
           
            return $query_result->id;
        } else {
            return null;
        }
    }

    public function get_quiz_name() {
        global $DB;
        
        if (!empty($this->config->selected_quiz)) {
            $selected_quiz = $this->config->selected_quiz;
            $sql_query = 'select name from mdl_quiz where id = ' . $selected_quiz . ';';
            $query_result = $DB->get_record_sql($sql_query);   
           
            return $query_result->name;
        } else {
            return null;
        }
    }

    public function define_teacher_text() {
        global $CFG;

        $presentation_text = '';
        $hr = '<hr/>';
        $main_text = '';
        $secondary_text = '';

        if (empty($this->config->selected_quiz)) {
            $presentation_text = '<p class="ics-light-text">Olá, professor! Para que o Assistente funcione corretamente, preciso que você me configure. </p>';
            $main_text = '<ol class="ics-config-list">
            <li>Clique no ícone de engrenagem da disciplina e selecione “Ativar edição”;</li>

            <li>Com a edição ativada, clique na engrenagem deste bloco e selecione “Configurar bloco Assistente de ICC”;</li>
            
            <li>Na página de configuração, preencha a seção “Configurações do Bloco” de acordo com suas preferências.</li>
            </ol>
            
            <p>Ainda não há nenhum Formulário de Percepção selecionado.</p>';
            $secondary_text = '<p class="ics-light-text">Uma vez configurado, o Assistente estará pronto para auxiliar seus alunos!</p>';
        } else {
            $presentation_text = '<p class="ics-light-text">Olá, professor! Caso deseje alterar as configurações do Assistente, siga os passos abaixo.</p>';
            $main_text = '<ol dlass="ics-config-list">
            <li>Clique no ícone de engrenagem da disciplina e selecione “Ativar edição”;</li>

            <li>Com a edição ativada, clique na engrenagem deste bloco e selecione “Configurar bloco Assistente de ICC”;</li>
            
            <li>Na página de configuração, preencha a seção “Configurações do Bloco” de acordo com suas preferências.</li>
            </ol>
            <p><span class="ics-light-text">O questionário selecionado é:</span> ' . $this->get_quiz_name() . '.</p>';

            $secondary_text = '<p class="ics-light-text">Uma vez configurado, o Assistente estará pronto para auxiliar seus alunos!</p>';
        }
        return $presentation_text . $hr . $main_text . $secondary_text;
    }

    public function define_initial_text() {
        global $CFG;

        $presentation_text = '<p class="ics-light-text">Olá! Sou seu Assistente nesta disciplina. Meu objetivo é te auxiliar no seu processo de aprendizado!</p>';
        $hr = '<hr/>';
        $main_text = '';
        $recommended_list = '';
        $secondary_text = '';
        $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . $this->get_quiz_module_id();

        $user_grade = $this->get_user_grade($this->config->selected_quiz);

        if (empty($this->config->selected_quiz)) { 
            return '';
        } elseif (empty($user_grade)) {
            $main_text = '<p>Para que possamos trabalhar bem juntos, preciso que você responda o <a href="' . $quiz_link . '">Formulário de Percepção</a>.</p>';

            $secondary_text = '<p class="ics-light-text">Em caso de dúvidas, procure seu professor, tutor ou monitor.</p>';
        } elseif ($user_grade == 4) {
            $main_text = '<p>Não tenho nenhuma recomendação para você no momento, bons estudos!</p>';

            $secondary_text = '<p class="ics-light-text">Em caso de dúvidas, procure seu professor, tutor ou monitor.</p>';
        } elseif (( $user_grade == 2) || ($user_grade == 3)) {
            $main_text = '<p>Antes de iniciar seus estudos, sugiro que você dedique um pouco de tempo nos conteúdos abaixo:</p>';

            $recommended_list = '<ul class="ics-list"><li><a href="https://youtube.com">Vídeo sobre Programação em Python;</a></li><li><a href="https://youtube.com">Mais exemplos.</a></li></ul>';

            $secondary_text = '<p class="ics-light-text">É importante que você dê uma olhada nesses conteúdos. Trabalhar esses conceitos pode acelerar o seu desempenho nas atividades futuras da disciplina.</p>';
        } elseif (($user_grade == 0) || ($user_grade == 1)) {
            $main_text = '<p>Antes de iniciar seus estudos, sugiro que você dedique um pouco de tempo nos conteúdos abaixo:</p>';

            $recommended_list = '<ul class="ics-list"><li><a href="https://youtube.com">Introdução ao Pensamento Computacional;</a></li><li><a href="https://youtube.com">Vídeo sobre Lógica de Programação;</a></li><li><a href="https://youtube.com">Mais exemplos.</a></li></ul>';

            $secondary_text = '<p class="ics-light-text">É importante que você dê uma olhada nesses conteúdos. Trabalhar esses conceitos pode acelerar o seu desempenho nas atividades futuras da disciplina.</p>';
        }

        return $presentation_text . $hr . $main_text . $recommended_list . $secondary_text;
    }

    public function get_timeclose_quiz($quiz_id) {
        global $COURSE, $DB;

        $sql_query = 'select timeclose from mdl_quiz where course = ' . $COURSE->id . ' and id = ' . $quiz_id . ';';
        $query_result = $DB->get_record_sql($sql_query);
        return $query_result->timeclose;
    }

    public function define_list_support_text() {
        if (!empty($this->config->list_7) && ($this->get_timeclose_quiz($this->config->list_7) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_7))) {
            return "Quiz 7";
        } elseif (!empty($this->config->list_6) && ($this->get_timeclose_quiz($this->config->list_6) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_6))) {
            return "Quiz 6";
        } elseif (!empty($this->config->list_5) && ($this->get_timeclose_quiz($this->config->list_5) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_5))) {
            return "Quiz 5";
        } elseif (!empty($this->config->list_4) && ($this->get_timeclose_quiz($this->config->list_4) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_4))) {
            return "Quiz 4";
        } elseif (!empty($this->config->list_3) && ($this->get_timeclose_quiz($this->config->list_3) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_3))) {
            return "Quiz 3";
        } elseif (!empty($this->config->list_2) && ($this->get_timeclose_quiz($this->config->list_2) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_2))) {
            return "Quiz 2";
        } else {
            return "Quiz 1 Nota: " . $this->get_user_grade($this->config->list_1);
        }
    }

    public function get_content() {
        global $CFG, $USER, $COURSE;

        $context = context_course::instance($COURSE->id, MUST_EXIST);

        if ($this->content !== null) {
            return $this->content;
        }
     
        $this->content =  new stdClass;

        if (has_capability('moodle/course:update', $context, $USER->id)) {
            $this->content->text = $this->define_teacher_text();
        } elseif (!empty($this->config->list_1) && ($this->get_timeclose_quiz($this->config->list_1) != 0) && (time() > $this->get_timeclose_quiz($this->config->list_1))) {
            $this->content->text = $this->define_list_support_text();
        } else {
            $this->content->text = $this->define_initial_text();
        }
        
        return $this->content;

    }
}
    