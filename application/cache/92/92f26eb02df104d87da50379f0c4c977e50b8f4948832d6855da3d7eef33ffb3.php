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

/* index.html.twig */
class __TwigTemplate_dc98a7ca6e814fb28c9eac8964608816f0fe6b40a6e1a6ff3bf726b51bf6a51a extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'body' => [$this, 'block_body'],
            'scriptjs' => [$this, 'block_scriptjs'],
        ];
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        $this->parent = $this->loadTemplate("base.html.twig", "index.html.twig", 1);
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 2
    public function block_body($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 3
        echo "    
    <main>
        <div class=\"sticky\">

        </div>
        <div class=\"item transform fixed-bottom\" id=\"stick\">
            <div class=\"container item-content\">
                <div class=\"row\">
                    <div class=\"col-8\">
                        <img src=\"images/arold.jpeg\" alt=\"arold\" class=\"item-picture\">
                    </div>
                    <div class=\"col-4\">
                        <p>Adresse mail</p>
                        <p>Nom </br> Prenom</p>
                        <p>Téléphone</p>
                        <p>Catégorie</p>
                        <p>Description</p>
                    </div>
                </div>
            </div>
            <div>
                <button class=\"close\">Fermer</button>
            </div>
        </div>
        <div class=\"container core\">
            ";
        // line 28
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["list_ads"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["ad"]) {
            // line 29
            echo "            <div class=\"row section\">
                <div class=\"col-4\">
                    <img src=\"";
            // line 31
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["ad"], "a_image_url", [], "any", false, false, false, 31), "html", null, true);
            echo "\" alt=\"arold\" class=\"picture\">
                </div>
                <div class=\"col-6\">
                    <p>Nom </br>Prenom</p>
                    <p>Catégorie </br>Prix</p>
                    <button type=\"button\" id=\"button\" value=\"\">Plus d'informations</i></button>
                </div>
                <div class=\"col-2\">
                    <a class=\"modif\" uk-icon=\"file-edit\" title=\"Modifier\" href=></a>
                    <svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-trash\" fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\"></svg>
                </div>
            </div>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['ad'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo "        </div>
    </main>
    <footer>

    </footer>
    ";
    }

    // line 50
    public function block_scriptjs($context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 51
        echo "        ";
        $this->displayParentBlock("scriptjs", $context, $blocks);
        echo "
        
    ";
    }

    public function getTemplateName()
    {
        return "index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  118 => 51,  114 => 50,  105 => 44,  86 => 31,  82 => 29,  78 => 28,  51 => 3,  47 => 2,  36 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "index.html.twig", "G:\\wamp\\www\\acs\\annonce\\application\\template\\index.html.twig");
    }
}
