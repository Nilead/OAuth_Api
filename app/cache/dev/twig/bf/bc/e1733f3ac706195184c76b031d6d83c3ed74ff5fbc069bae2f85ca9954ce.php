<?php

/* OAuthServerBundle:Client:index.html.twig */
class __TwigTemplate_bfbce1733f3ac706195184c76b031d6d83c3ed74ff5fbc069bae2f85ca9954ce extends Twig_Template
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
        echo "    <h1>Client page</h1>
    <a href=\"";
        // line 5
        echo $this->env->getExtension('routing')->getPath("homepage");
        echo "\">Homepage</a>
    <p>
        Client_name: ";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "name"), "html", null, true);
        echo "
    </p>
    <p>
        Client_id: ";
        // line 10
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "getPublicId"), "html", null, true);
        echo "
    </p>
    <p>
        Client_secret: ";
        // line 13
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "getSecret"), "html", null, true);
        echo "
    </p>
    <p>
        Client_redirect_uri:
    <ul>
        ";
        // line 18
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "redirectUris"));
        foreach ($context['_seq'] as $context["_key"] => $context["uri"]) {
            // line 19
            echo "            <li>
                ";
            // line 20
            echo twig_escape_filter($this->env, (isset($context["uri"]) ? $context["uri"] : $this->getContext($context, "uri")), "html", null, true);
            echo "
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['uri'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 23
        echo "    </ul>
    </p>
    <p>
        Grant type:
    <ul>
        ";
        // line 28
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable($this->getAttribute((isset($context["client"]) ? $context["client"] : $this->getContext($context, "client")), "allowedGrantTypes"));
        foreach ($context['_seq'] as $context["_key"] => $context["type"]) {
            // line 29
            echo "            <li>
                ";
            // line 30
            echo twig_escape_filter($this->env, (isset($context["type"]) ? $context["type"] : $this->getContext($context, "type")), "html", null, true);
            echo "
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['type'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 33
        echo "    </ul>
    </p>
    <p>
        Info:
    <blockquote>
        ";
        // line 38
        if (((isset($context["json"]) ? $context["json"] : $this->getContext($context, "json")) == null)) {
            // line 39
            echo "            Permission not granted
        ";
        } else {
            // line 41
            echo "            ";
            echo twig_escape_filter($this->env, (isset($context["json"]) ? $context["json"] : $this->getContext($context, "json")), "html", null, true);
            echo "
        ";
        }
        // line 43
        echo "    </blockquote>
    </p>
    <form method=\"post\" action=\"\">
        <select name=\"choice_access\">
            <option value=\"id_access\">Id</option>
            <option value=\"username_access\">Username</option>
            <option value=\"email_access\">Email</option>
            <option value=\"dob_access\">Date of Birth</option>
            <option value=\"roles_access\">Roles</option>
            <option value=\"all_access\">All</option>
        </select>
        ";
        // line 54
        if ($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user")) {
            // line 55
            echo "            <button type=\"submit\">Grant Access</button>
        ";
        } else {
            // line 57
            echo "            <button type=\"submit\" disabled>Grant Access</button>
        ";
        }
        // line 59
        echo "    </form>
    ";
        // line 60
        if ($this->getAttribute((isset($context["app"]) ? $context["app"] : $this->getContext($context, "app")), "user")) {
            // line 61
            echo "        <a href=\"";
            echo $this->env->getExtension('routing')->getPath("fos_user_security_logout");
            echo "\">
            <button>Logout</button>
        </a>
    ";
        } else {
            // line 65
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
        return "OAuthServerBundle:Client:index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  153 => 65,  145 => 61,  143 => 60,  140 => 59,  136 => 57,  132 => 55,  130 => 54,  117 => 43,  111 => 41,  107 => 39,  105 => 38,  98 => 33,  89 => 30,  86 => 29,  82 => 28,  75 => 23,  66 => 20,  63 => 19,  59 => 18,  51 => 13,  45 => 10,  39 => 7,  34 => 5,  31 => 4,  28 => 3,);
    }
}
