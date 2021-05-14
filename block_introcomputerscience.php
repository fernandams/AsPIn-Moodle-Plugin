<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/introcomputerscience/database_functions.php');

class block_introcomputerscience extends block_base {
    public function init() {
        $this->title = get_string('introcomputerscience', 'block_introcomputerscience');
    }

    public function specialization() {
        set_grade_condition_availability(get_quiz_module_id($this->config->list_1), $this->config->selected_quiz, 1);
        set_grade_condition_availability(get_quiz_module_id($this->config->list_1_not_math), $this->config->selected_quiz, 0);
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
            <p><span class="ics-light-text">O questionário selecionado é:</span> ' . get_quiz_name($this->config->selected_quiz) . '.</p>';

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
        $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($this->config->selected_quiz);

        $user_grade = get_user_grade($this->config->selected_quiz);

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

    public function define_after_list_support_text() {
        $presentation_text = '<p class="ics-light-text">Olá! Sou seu Assistente nesta disciplina. Meu objetivo é te auxiliar no seu processo de aprendizado!</p>';
        $hr = '<hr/>';
        $main_text = '';
        $recommended_array = [];
        $subjects = [];
        $subjects_text = '';

        $list_1 = $this->config->list_1;
        $list_2 = $this->config->list_2;
        $list_3 = $this->config->list_3;
        $list_4 = $this->config->list_4;
        $list_5 = $this->config->list_5;
        $list_6 = $this->config->list_6;
        $list_7 = $this->config->list_7;

        
        if (get_user_grade($list_1) > 5) {
            $main_text = '<p>Parabéns pelo seu desempenho na lista 1! Continue assim!';
        } else {
            $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
            array_push($subjects, 'Variáveis e Expressões');
            array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Variáveis e Expressões.</a></li></ul>');
        }

        if (!empty($list_2) && (get_timeclose_quiz($list_2) != 0) && (time() > get_timeclose_quiz($list_2))) {
            if (get_user_grade($list_2) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 2! Continue assim!';
            } else {
                $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
                array_push($subjects, 'Estrutura de Decisão');
                array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Estrutura de Decisão.</a></li></ul>');
            }
        }         
        
        if (!empty($list_3) && (get_timeclose_quiz($list_3) != 0) && (time() > get_timeclose_quiz($list_3))) {
            if (get_user_grade($list_3) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 3! Continue assim!';
            } else {
                $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
                array_push($subjects, 'Estrutura de Repetição');
                array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Estrutura de Repetição.</a></li></ul>');
            }
        } 

        if (!empty($list_4) && (get_timeclose_quiz($list_4) != 0) && (time() > get_timeclose_quiz($list_4))) {
            if (get_user_grade($list_4) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 4! Continue assim!';
            } else {
                $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
                array_push($subjects, 'Funções');
                array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Funções.</a></li></ul>');
            }
        } 
        
        if (!empty($list_5) && (get_timeclose_quiz($list_5) != 0) && (time() > get_timeclose_quiz($list_5))) {
            if (get_user_grade($list_5) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 5! Continue assim!';
            } else {
                $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
                array_push($subjects, 'Strings');
                array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Strings.</a></li></ul>');
            }
        } 
        
        if (!empty($list_6) && (get_timeclose_quiz($list_6) != 0) && (time() > get_timeclose_quiz($list_6))) {
            if (get_user_grade($list_6) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 6! Continue assim!';
            } else {
                $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
                array_push($subjects, 'Listas');
                array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Listas.</a></li></ul>');
            }
        } 

        if (!empty($list_7) && (get_timeclose_quiz($list_7) != 0) && (time() > get_timeclose_quiz($list_7))) {
            if (get_user_grade($list_7) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 7! Continue assim!';
            } else {
                $main_text = '<p>Parabéns pela sua dedicação em realizar as listas! Continue se esforçando para aprender o conteúdo!';
                array_push($subjects, 'Tuplas e Dicionários');
                array_push($recommended_array, '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Tuplas e Dicionários.</a></li></ul>');
            }
        } 


        if (sizeof($subjects) > 0) {
            $main_text = $main_text . '<br/>Notei que você pode ter tido dificuldade em alguns conteúdos.</p>';
            foreach ($subjects as $key=>$subject) {
               $subjects_text = $subjects_text . '<p class="ics-light-text">Para ' . $subject . ', dê uma olhada em:</p>' . $recommended_array[$key];
            }
        } else {
            $main_text = $main_text . '</p>';
        }

        return $presentation_text . $hr . $main_text . $subjects_text;
    }

    public function define_before_list_support_text() {
        $hr = '<hr/>';
        $main_text = '';
        $recommended_text = '';
        $secondary_text = '<p class="ics-light-text">Busque separar um tempo para realizar esses exercícios. Aprender a programar te prepara não só para seu curso, mas também para seu futuro!</p>';
        
        $selected_quiz = $this->config->selected_quiz;
        $list_1 = $this->config->list_1;
        $list_2 = $this->config->list_2;
        $list_3 = $this->config->list_3;
        $list_4 = $this->config->list_4;
        $list_5 = $this->config->list_5;
        $list_6 = $this->config->list_6;
        $list_7 = $this->config->list_7;

        if (empty(get_user_grade($selected_quiz))) {
            return '';
        } elseif (time() < get_timeclose_quiz($list_1) && empty(get_user_grade($list_1))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Variáveis e Expressões. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Variáveis e Expressões.</a></li></ul>';

        } elseif (time() < get_timeclose_quiz($list_2) && empty(get_user_grade($list_2))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Estrutura de Decisão. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Estrutura de Decisão.</a></li></ul>';

        }  elseif (time() < get_timeclose_quiz($list_3) && empty(get_user_grade($list_3))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Estrutura de Repetição. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Estrutura de Repetição.</a></li></ul>';

        }  elseif (time() < get_timeclose_quiz($list_4) && empty(get_user_grade($list_4))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Funções. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Funções.</a></li></ul>';

        }  elseif (time() < get_timeclose_quiz($list_5) && empty(get_user_grade($list_5))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Strings. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Strings.</a></li></ul>';

        }  elseif (time() < get_timeclose_quiz($list_6) && empty(get_user_grade($list_6))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Listas. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Listas.</a></li></ul>';

        } elseif (time() < get_timeclose_quiz($list_7) && empty(get_user_grade($list_7))) {
            $main_text = '<p>Lembre-se que a próxima lista é sobre Tuplas e Dicionários. Isso pode te ajudar a estudar:</p>';
            $recommended_text = '<ul class="ics-list"><li><a href="https://youtube.com">Exercícios contextualizados de Tuplas e Dicionários.</a></li></ul>';

        } else {
            return '';
        }

        return $hr . $main_text . $recommended_text . $secondary_text;
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
        } elseif (!empty($this->config->list_1) && (get_timeclose_quiz($this->config->list_1) != 0) && (time() > get_timeclose_quiz($this->config->list_1))) {
            $this->content->text = $this->define_after_list_support_text() . $this->define_before_list_support_text();
        } else {
            $this->content->text = $this->define_initial_text() . $this->define_before_list_support_text();
        }
        
        return $this->content;

    }
}
    