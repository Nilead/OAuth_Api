<?php

/* FOSOAuthServerBundle:Authorize:authorize.html.twig */
class __TwigTemplate_cf88083f923500b87ba47fd3c84dd5f37ff19dc9dd58aafeacde2f68cb7c5764 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("FOSOAuthServerBundle::layout.html.twig");

        $this->blocks = array(
            'fos_oauth_server_content' => array($this, 'block_fos_oauth_server_content'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "FOSOAuthServerBundle::layout.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_fos_oauth_server_content($context, array $blocks = array())
    {
        // line 4
        $this->env->loadTemplate("FOSOAuthServerBundle:Authorize:authorize_content.html.twig")->display($context);
    }

    public function getTemplateName()
    {
        return "FOSOAuthServerBundle:Authorize:authorize.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  28 => 3,);
    }
}
