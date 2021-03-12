<?php
class block_introcomputerscience extends block_base {
    public function init() {
        $this->title = get_string('introcomputerscience', 'block_introcomputerscience');
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
     
        return $this->content;

    }
}