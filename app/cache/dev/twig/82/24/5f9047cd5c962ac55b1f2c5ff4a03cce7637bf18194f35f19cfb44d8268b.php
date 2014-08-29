<?php

/* OAuthServerBundle:Default:index.html.twig */
class __TwigTemplate_82245f9047cd5c962ac55b1f2c5ff4a03cce7637bf18194f35f19cfb44d8268b extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = $this->env->loadTemplate("::base.html.twig");

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "::base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "    <h1>Demo page</h1>
    <a href=\"";
        // line 5
        echo $this->env->getExtension('routing')->getPath("get_free_to_access");
        echo "\">Test API Session Access</a><br>
    Available Client:
    <div>
        <ul>
            ";
        // line 9
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["clients"]) ? $context["clients"] : $this->getContext($context, "clients")));
        foreach ($context['_seq'] as $context["_key"] => $context["client"]) {
            // line 10
            echo "                <li>
                    <a href=";
            // line 11
            echo twig_escape_filter($this->env, $this->env->getExtension('routing')->getPath("acme_oauth_server_client", array("clientID" => $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "ID"))), "html", null, true);
            echo "> ";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "getName", array(), "method"), "html", null, true);
            echo "</a>
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['client'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "        </ul>
    </div>
    <div><a href=\"";
        // line 16
        echo $this->env->getExtension('routing')->getPath("user");
        echo "\">User profile</a></div>

    ";
        // line 18
        if ($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user")) {
            // line 19
            echo "        <a href=\"";
            echo $this->env->getExtension('routing')->getPath("fos_user_security_logout");
            echo "\">
            <button>Logout</button>
        </a>
    ";
        } else {
            // line 23
            echo "        <a href=\"";
            echo $this->env->getExtension('routing')->getPath("fos_user_security_login");
            echo "\">
            <button>Login</button>
        </a>
    ";
        }
    }

    public function getTemplateName()
    {
        return "OAuthServerBundle:Default:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 23,  70 => 19,  68 => 18,  63 => 16,  59 => 14,  48 => 11,  45 => 10,  41 => 9,  34 => 5,  31 => 4,  28 => 3,);
    }
}
