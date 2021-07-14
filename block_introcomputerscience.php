<?php

require_once(dirname(__FILE__) . '/../../config.php');
require_once($CFG->dirroot . '/blocks/introcomputerscience/database_functions.php');

class block_introcomputerscience extends block_base {
    public function init() {
        $this->title = get_string('introcomputerscience', 'block_introcomputerscience');
    }

    public function specialization() {
        if (!empty($this->config->section) && !empty($this->config->selected_quiz)) {
            set_grade_condition_availability($this->config->section, $this->config->selected_quiz);
        }
    }

    // public function is_student_from_aimed_course() {
    //     if (empty($this->config->selected_quiz)) {
    //         return false;
    //     } else {
    //         $user_grade = get_user_grade($this->config->selected_quiz);
    //         if ($user_grade < 5) {
    //             return true;
    //         } else {
    //             return false;
    //         }
    //     }
    // }

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
        global $CFG, $COURSE;

        $presentation_text = '<p class="ics-light-text">Olá! Sou seu Assistente nesta disciplina. Meu objetivo é te auxiliar no seu processo de aprendizado!</p>';
        $hr = '<hr/>';
        $main_text = '';
        $secondary_text = '';
        $user_grade = 0;
        
        if (empty($this->config->selected_quiz)) { 
            return '';
        } else {     
            $user_grade = get_user_grade($this->config->selected_quiz);
        } 
        
        if (empty($user_grade)) {
            $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($this->config->selected_quiz);
    
            $presentation_text = '<p class="ics-light-text">Olá! Sou o Assistente de ICC, um plugin desenvolvido por alunos de Ciência da Computação. E preciso da sua ajuda!</p>';
            $main_text = '<p>Para que eu possa te conhecer melhor, preciso que você responda o <a href="' . $quiz_link . '">Formulário de Percepção</a>.</p>';

            $secondary_text = '<p class="ics-light-text">Em caso de dúvidas, procure seu professor, tutor ou monitor.</p>';

        } elseif ($user_grade == 0) {
            $main_text = '<p>Não tenho nenhuma recomendação para você no momento, bons estudos!</p>';

            $secondary_text = '<p class="ics-light-text">Em caso de dúvidas, procure seu professor, tutor ou monitor.</p>';

        } elseif (( $user_grade == 1) || ($user_grade == 2)) {
            $section_link = $CFG->wwwroot . '/course/view.php?id=' . $COURSE->id . '#section-' . get_section_number($this->config->section);

            $main_text = '<p>Mesmo que você já saiba pelo menos um pouquinho de programação, sugiro que você dedique um pouco de tempo na seção <a href="' . $section_link . '">Pensando como um computador</a> que adicionei para você. </p>';

            $secondary_text = '<p class="ics-light-text">É importante que você dê uma olhada nesses conteúdos curtinhos. Fortalecer esses conceitos pode acelerar o seu desempenho nas atividades futuras da disciplina.</p>';

        } elseif (($user_grade == 3) || ($user_grade == 4)) {
            $section_link = $CFG->wwwroot . '/course/view.php?id=' . $COURSE->id . '#section-' . get_section_number($this->config->section);

            $main_text = '<p>Antes de iniciar seus estudos, sugiro que você dedique um pouco de tempo na seção <a href="' . $section_link . '">Pensando como um computador</a> que adicionei para você.</p>';

            $secondary_text = '<p class="ics-light-text">É importante que você dê uma olhada nesses conteúdos curtinhos. Trabalhar esses conceitos pode acelerar o seu desempenho nas atividades futuras da disciplina.</p>';
        }

        return $presentation_text . $hr . $main_text . $secondary_text;
    }

    public function define_after_list_support_text() {
        $presentation_text = '<p class="ics-light-text">Olá! Sou seu Assistente nesta disciplina. Meu objetivo é te auxiliar no seu processo de aprendizado!</p>';
        $hr = '<hr/>';
        $main_text = '';
        $secondary_text = '';

        $list_1 = $this->config->list_1;
        $list_2 = $this->config->list_2;
        $list_3 = $this->config->list_3;
        $list_4 = $this->config->list_4;
        $list_5 = $this->config->list_5;
        $list_6 = $this->config->list_6;
        $list_7 = $this->config->list_7;

        if (!empty($list_7) && (get_timeclose_quiz($list_7) != 0) && (time() > get_timeclose_quiz($list_7))) {
            if (get_user_grade($list_7) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 7! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue!</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        } elseif (!empty($list_6) && (get_timeclose_quiz($list_6) != 0) && (time() > get_timeclose_quiz($list_6))) {
            if (get_user_grade($list_6) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 6! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue!</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        } elseif (!empty($list_5) && (get_timeclose_quiz($list_5) != 0) && (time() > get_timeclose_quiz($list_5))) {
            if (get_user_grade($list_5) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 5! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue!</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        } elseif (!empty($list_4) && (get_timeclose_quiz($list_4) != 0) && (time() > get_timeclose_quiz($list_4))) {
            if (get_user_grade($list_4) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 4! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue!</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        } elseif (!empty($list_3) && (get_timeclose_quiz($list_3) != 0) && (time() > get_timeclose_quiz($list_3))) {
            if (get_user_grade($list_3) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 3! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue!</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        } elseif (!empty($list_2) && (get_timeclose_quiz($list_2) != 0) && (time() > get_timeclose_quiz($list_2))) {
            if (get_user_grade($list_2) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 2! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue!</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        } elseif (!empty($list_1) && (get_timeclose_quiz($list_1) != 0) && (time() > get_timeclose_quiz($list_1))) {
            if (get_user_grade($list_1) > 5) {
                $main_text = '<p>Parabéns pelo seu desempenho na lista 1! Continue assim!</p>';
                $secondary_text = '';
            } else {
                $main_text = '<p>Parabéns pelo seu esforço! Aprender a programar pode ser difícil, mas tenho certeza que com persistência você consegue</p>';
                $secondary_text = '<p class="ics-light-text">Se você sentir que precisa de ajuda, não hesite em procurar o(a) professor(a) ou os monitores da disciplina. Eles estão aqui para te ajudar.</p>';
            }
        }
        
        return $presentation_text . $hr . $main_text . $secondary_text;
    }

    public function define_before_list_support_text() {
        global $CFG;

        $hr = '<hr/>';
        $main_text = '';
        $secondary_text = '<p class="ics-light-text">Busque separar um tempo para praticar os exercícios das listas. Aprender a programar te prepara não só para seu curso, mas também para seu futuro!</p>';
        
        if (!empty($this->config->selected_quiz)) { 
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
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_1);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Variáveis e Expressões</a>.</p>';

            } elseif (time() < get_timeclose_quiz($list_2) && empty(get_user_grade($list_2))) {
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_2);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Estrutura de Decisão</a>.</p>';

            }  elseif (time() < get_timeclose_quiz($list_3) && empty(get_user_grade($list_3))) {
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_3);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Estrutura de Repetição</a>.</p>';

            }  elseif (time() < get_timeclose_quiz($list_4) && empty(get_user_grade($list_4))) {
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_4);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Funções</a>.</p>';

            }  elseif (time() < get_timeclose_quiz($list_5) && empty(get_user_grade($list_5))) {
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_5);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Strings</a>.</p>';

            }  elseif (time() < get_timeclose_quiz($list_6) && empty(get_user_grade($list_6))) {
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_6);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Listas</a>.</p>';

            } elseif (time() < get_timeclose_quiz($list_7) && empty(get_user_grade($list_7))) {
                $quiz_link = $CFG->wwwroot . '/mod/quiz/view.php?id=' . get_quiz_module_id($list_7);

                $main_text = '<p>Lembre-se que a próxima lista é sobre <a href="' . $quiz_link . '">Tuplas e Dicionários</a>.</p>';

            } else {
                return '';
            }

            return $hr . $main_text . $secondary_text;
        } else {
            return '';
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
        } elseif (!empty($this->config->list_1) && (get_timeclose_quiz($this->config->list_1) != 0) && (time() > get_timeclose_quiz($this->config->list_1))) {
            $this->content->text = $this->define_after_list_support_text() . $this->define_before_list_support_text();
        } else {
            $this->content->text = $this->define_initial_text() . $this->define_before_list_support_text();
        }
        
        return $this->content;

    }
}
    