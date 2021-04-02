<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->libdir.'/gradelib.php');

class block_introcomputerscience extends block_base {
    public function init() {
        $this->title = get_string('introcomputerscience', 'block_introcomputerscience');
    }

    public function get_user_grade() {
        global $USER, $COURSE;
        $selected_quiz = null;
        
        if (!empty($this->config->selected_quiz)) {
            $selected_quiz = $this->config->selected_quiz;
        }

        $user_id = $USER->id;
        $user_name = $USER->username;
        $course_id = $COURSE->id;

        $grading_info = grade_get_grades($course_id, 'mod', 'quiz', $selected_quiz, $user_id);
 
        $user_grade = $grading_info->items[0]->grades[$user_id]->grade;
       
        return $user_grade;
    }
   
    public function define_text_content() {
        $presentation_text = '<p class="ics-light-text">Olá! Sou seu Assistente nesta disciplina. Meu objetivo é te auxiliar no seu processo de aprendizado!</p>';
        $hr = '<hr/>';
        $main_text = '';
        $recommended_list = '';
        $secondary_text = '';
    
        if (empty($this->config->selected_quiz)) {
            $main_text = '<p>Professor, por favor, selecione o questionário de percepção nas configurações deste bloco!</p>';
        } else {
            $user_grade = $this->get_user_grade();

            if (empty($user_grade)) {
                $main_text = '<p>Para que possamos trabalhar bem juntos, preciso que você responda o <a href="https://youtube.com">Formulário de Percepção</a>.</p>';

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
        }

        return $presentation_text . $hr . $main_text . $recommended_list . $secondary_text;
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }
     
        $this->content =  new stdClass;
        $this->content->text = $this->define_text_content();
        
        return $this->content;

    }
}