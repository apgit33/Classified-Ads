<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* base.html.twig */
class __TwigTemplate_eaa3213cd6af462bc40d136cf53278eaed169ccc1d0f02e6138415604ae5991f extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
            'header' => [$this, 'block_header'],
            'body' => [$this, 'block_body'],
            'scriptjs' => [$this, 'block_scriptjs'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"fr\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Document</title>
    <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css\" integrity=\"sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z\" crossorigin=\"anonymous\">
    
    <script src=\"https://code.jquery.com/jquery-3.5.1.slim.min.js\" integrity=\"sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj\" crossorigin=\"anonymous\"></script>
<script src=\"https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js\" integrity=\"sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN\" crossorigin=\"anonymous\"></script>
<script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js\" integrity=\"sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV\" crossorigin=\"anonymous\"></script><script src=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js\" integrity=\"sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV\" crossorigin=\"anonymous\"></script>
    <link rel=\"stylesheet\" href=\"css/style.css\">
</head>

<body>
    ";
        // line 16
        $this->displayBlock('header', $context, $blocks);
        // line 25
        $this->displayBlock('body', $context, $blocks);
        // line 28
        $this->displayBlock('scriptjs', $context, $blocks);
        // line 31
        echo "
</body>
</html>";
    }

    // line 16
    public function block_header($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 17
        echo "    <header class=\"fixed-top\">
        <nav class=\"navbar navbar-light bg-light \">
            <span class=\"navbar-brand mb-0 h1\">Lecoinsympa</span>
            <a href=\"edit.html\">Ajouter une annonce</a>
        </nav>

    </header>
    ";
    }

    // line 25
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 26
        echo "    
";
    }

    // line 28
    public function block_scriptjs($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 29
        echo "    <script src=\"js/script.js\"></script>
";
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function getDebugInfo()
    {
        return array (  97 => 29,  93 => 28,  88 => 26,  84 => 25,  73 => 17,  69 => 16,  63 => 31,  61 => 28,  59 => 25,  57 => 16,  40 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "base.html.twig", "G:\\wamp\\www\\acs\\annonce\\application\\template\\base.html.twig");
    }
}
