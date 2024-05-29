<?php
class View
{
    private $sections = [];
    private $currentSection;

    public function extend($layout)
    {
        ob_start();
        require 'views/' . $layout . '.php';
        ob_end_clean();
    }

    public function section($name)
    {
        $this->currentSection = $name;
        ob_start();
    }

    public function endSection()
    {
        $this->sections[$this->currentSection] = ob_get_clean();
    }

    public function renderSection($name)
    {
        echo $this->sections[$name] ?? '';
    }
}
