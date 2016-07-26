<?php

/* Grid/default.html */
class __TwigTemplate_32e505f9e3fa03e3333374c1c63f680846ddab12d1d5a9091865c7fe9f9b52cf extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"";
        echo twig_escape_filter($this->env, (isset($context["class"]) ? $context["class"] : null), "html", null, true);
        echo " grids mdl-shadow--2dp\">
    ";
        // line 2
        echo twig_escape_filter($this->env, (isset($context["content"]) ? $context["content"] : null), "html", null, true);
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "Grid/default.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 2,  19 => 1,);
    }
}
/* <div class="{{class}} grids mdl-shadow--2dp">*/
/*     {{content}}*/
/* </div>*/
