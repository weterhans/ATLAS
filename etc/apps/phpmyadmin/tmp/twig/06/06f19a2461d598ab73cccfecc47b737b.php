<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* database/data_dictionary/index.twig */
class __TwigTemplate_7a03bf8733b2f7ffc44a7dce8ee6bcee extends Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 1
        yield "<div class=\"container-fluid\">
  <h1>";
        // line 2
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["database"] ?? null), "html", null, true);
        yield "</h1>
  ";
        // line 3
        if ( !Twig\Extension\CoreExtension::testEmpty(($context["comment"] ?? null))) {
            // line 4
            yield "    <p>";
yield _gettext("Database comment:");
            yield " <em>";
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["comment"] ?? null), "html", null, true);
            yield "</em></p>
  ";
        }
        // line 6
        yield "
  <p class=\"d-print-none\">
    <button type=\"button\" class=\"btn btn-secondary jsPrintButton\">";
        // line 8
        yield PhpMyAdmin\Html\Generator::getIcon("b_print", _gettext("Print"), true);
        yield "</button>
  </p>

  <div>
    ";
        // line 12
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["tables"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["table"]) {
            // line 13
            yield "      <div>
        <h2>";
            // line 14
            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["table"], "name", [], "any", false, false, false, 14), "html", null, true);
            yield "</h2>
        ";
            // line 15
            if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["table"], "comment", [], "any", false, false, false, 15))) {
                // line 16
                yield "          <p>";
yield _gettext("Table comments:");
                yield " <em>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["table"], "comment", [], "any", false, false, false, 16), "html", null, true);
                yield "</em></p>
        ";
            }
            // line 18
            yield "
        <table class=\"table table-striped align-middle\">
          <thead>
            <tr>
              <th>";
yield _gettext("Column");
            // line 22
            yield "</th>
              <th>";
yield _gettext("Type");
            // line 23
            yield "</th>
              <th>";
yield _gettext("Null");
            // line 24
            yield "</th>
              <th>";
yield _gettext("Default");
            // line 25
            yield "</th>
              ";
            // line 26
            if (CoreExtension::getAttribute($this->env, $this->source, $context["table"], "has_relation", [], "any", false, false, false, 26)) {
                // line 27
                yield "                <th>";
yield _gettext("Links to");
                yield "</th>
              ";
            }
            // line 29
            yield "              <th>";
yield _gettext("Comments");
            yield "</th>
              ";
            // line 30
            if (CoreExtension::getAttribute($this->env, $this->source, $context["table"], "has_mime", [], "any", false, false, false, 30)) {
                // line 31
                yield "                <th>";
yield _gettext("Media type");
                yield "</th>
              ";
            }
            // line 33
            yield "            </tr>
          </thead>
          <tbody>
            ";
            // line 36
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["table"], "columns", [], "any", false, false, false, 36));
            foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                // line 37
                yield "              <tr>
                <td class=\"text-nowrap\">
                  ";
                // line 39
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "name", [], "any", false, false, false, 39), "html", null, true);
                yield "
                  ";
                // line 40
                if (CoreExtension::getAttribute($this->env, $this->source, $context["column"], "has_primary_key", [], "any", false, false, false, 40)) {
                    // line 41
                    yield "                    <em>(";
yield _gettext("Primary");
                    yield ")</em>
                  ";
                }
                // line 43
                yield "                </td>
                <td lang=\"en\" dir=\"ltr\"";
                // line 44
                yield (((("set" != CoreExtension::getAttribute($this->env, $this->source, $context["column"], "type", [], "any", false, false, false, 44)) && ("enum" != CoreExtension::getAttribute($this->env, $this->source, $context["column"], "type", [], "any", false, false, false, 44)))) ? (" class=\"text-nowrap\"") : (""));
                yield ">
                  ";
                // line 45
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "print_type", [], "any", false, false, false, 45), "html", null, true);
                yield "
                </td>
                <td>";
                // line 47
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["column"], "is_nullable", [], "any", false, false, false, 47)) ? (_gettext("Yes")) : (_gettext("No"))), "html", null, true);
                yield "</td>
                <td class=\"text-nowrap\">
                  ";
                // line 49
                if (((null === CoreExtension::getAttribute($this->env, $this->source, $context["column"], "default", [], "any", false, false, false, 49)) && CoreExtension::getAttribute($this->env, $this->source, $context["column"], "is_nullable", [], "any", false, false, false, 49))) {
                    // line 50
                    yield "                    <em>NULL</em>
                  ";
                } else {
                    // line 52
                    yield "                    ";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "default", [], "any", false, false, false, 52), "html", null, true);
                    yield "
                  ";
                }
                // line 54
                yield "                </td>
                ";
                // line 55
                if (CoreExtension::getAttribute($this->env, $this->source, $context["table"], "has_relation", [], "any", false, false, false, 55)) {
                    // line 56
                    yield "                  <td>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "relation", [], "any", false, false, false, 56), "html", null, true);
                    yield "</td>
                ";
                }
                // line 58
                yield "                <td>";
                yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "comment", [], "any", false, false, false, 58), "html", null, true);
                yield "</td>
                ";
                // line 59
                if (CoreExtension::getAttribute($this->env, $this->source, $context["table"], "has_mime", [], "any", false, false, false, 59)) {
                    // line 60
                    yield "                  <td>";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "mime", [], "any", false, false, false, 60), "html", null, true);
                    yield "</td>
                ";
                }
                // line 62
                yield "              </tr>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 64
            yield "          </tbody>
        </table>

        ";
            // line 67
            if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["table"], "indexes", [], "any", false, false, false, 67))) {
                // line 68
                yield "          <h3>";
yield _gettext("Indexes");
                yield "</h3>

          <table class=\"table table-striped align-middle\">
            <thead>
              <tr>
                <th>";
yield _gettext("Keyname");
                // line 73
                yield "</th>
                <th>";
yield _gettext("Type");
                // line 74
                yield "</th>
                <th>";
yield _gettext("Unique");
                // line 75
                yield "</th>
                <th>";
yield _gettext("Packed");
                // line 76
                yield "</th>
                <th>";
yield _gettext("Column");
                // line 77
                yield "</th>
                <th>";
yield _gettext("Cardinality");
                // line 78
                yield "</th>
                <th>";
yield _gettext("Collation");
                // line 79
                yield "</th>
                <th>";
yield _gettext("Null");
                // line 80
                yield "</th>
                <th>";
yield _gettext("Comment");
                // line 81
                yield "</th>
              </tr>
            </thead>

            <tbody>
              ";
                // line 86
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["table"], "indexes", [], "any", false, false, false, 86));
                foreach ($context['_seq'] as $context["_key"] => $context["index"]) {
                    // line 87
                    yield "                ";
                    $context["columns_count"] = CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getColumnCount", [], "method", false, false, false, 87);
                    // line 88
                    yield "                <tr>
                <td rowspan=\"";
                    // line 89
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["columns_count"] ?? null), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getName", [], "method", false, false, false, 89), "html", null, true);
                    yield "</td>
                <td rowspan=\"";
                    // line 90
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["columns_count"] ?? null), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getType", [], "method", true, true, false, 90)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getType", [], "method", false, false, false, 90), CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getChoice", [], "method", false, false, false, 90))) : (CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getChoice", [], "method", false, false, false, 90))), "html", null, true);
                    yield "</td>
                <td rowspan=\"";
                    // line 91
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["columns_count"] ?? null), "html", null, true);
                    yield "\">";
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(((CoreExtension::getAttribute($this->env, $this->source, $context["index"], "isUnique", [], "method", false, false, false, 91)) ? (_gettext("Yes")) : (_gettext("No"))), "html", null, true);
                    yield "</td>
                <td rowspan=\"";
                    // line 92
                    yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["columns_count"] ?? null), "html", null, true);
                    yield "\">";
                    yield CoreExtension::getAttribute($this->env, $this->source, $context["index"], "isPacked", [], "method", false, false, false, 92);
                    yield "</td>

                ";
                    // line 94
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getColumns", [], "method", false, false, false, 94));
                    foreach ($context['_seq'] as $context["_key"] => $context["column"]) {
                        // line 95
                        yield "                  ";
                        if ((CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getSeqInIndex", [], "method", false, false, false, 95) > 1)) {
                            // line 96
                            yield "                    <tr>
                  ";
                        }
                        // line 98
                        yield "                  <td>
                    ";
                        // line 99
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getName", [], "method", false, false, false, 99), "html", null, true);
                        yield "
                    ";
                        // line 100
                        if ( !Twig\Extension\CoreExtension::testEmpty(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getSubPart", [], "method", false, false, false, 100))) {
                            // line 101
                            yield "                      (";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getSubPart", [], "method", false, false, false, 101), "html", null, true);
                            yield ")
                    ";
                        }
                        // line 103
                        yield "                  </td>
                  <td>";
                        // line 104
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getCardinality", [], "method", false, false, false, 104), "html", null, true);
                        yield "</td>
                  <td>";
                        // line 105
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getCollation", [], "method", false, false, false, 105), "html", null, true);
                        yield "</td>
                  <td>";
                        // line 106
                        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getNull", [true], "method", false, false, false, 106), "html", null, true);
                        yield "</td>

                  ";
                        // line 108
                        if ((CoreExtension::getAttribute($this->env, $this->source, $context["column"], "getSeqInIndex", [], "method", false, false, false, 108) == 1)) {
                            // line 109
                            yield "                    <td rowspan=\"";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(($context["columns_count"] ?? null), "html", null, true);
                            yield "\">";
                            yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape(CoreExtension::getAttribute($this->env, $this->source, $context["index"], "getComments", [], "method", false, false, false, 109), "html", null, true);
                            yield "</td>
                  ";
                        }
                        // line 111
                        yield "                  </tr>
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_iterated'], $context['_key'], $context['column'], $context['_parent'], $context['loop']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 113
                    yield "              ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['index'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 114
                yield "            </tbody>
          </table>
        ";
            } else {
                // line 117
                yield "          <p>";
yield _gettext("No index defined!");
                yield "</p>
        ";
            }
            // line 119
            yield "      </div>
    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['table'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 121
        yield "  </div>

  <p class=\"d-print-none\">
    <button type=\"button\" class=\"btn btn-secondary jsPrintButton\">";
        // line 124
        yield PhpMyAdmin\Html\Generator::getIcon("b_print", _gettext("Print"), true);
        yield "</button>
  </p>
</div>
";
        return; yield '';
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName()
    {
        return "database/data_dictionary/index.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable()
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo()
    {
        return array (  394 => 124,  389 => 121,  382 => 119,  376 => 117,  371 => 114,  365 => 113,  358 => 111,  350 => 109,  348 => 108,  343 => 106,  339 => 105,  335 => 104,  332 => 103,  326 => 101,  324 => 100,  320 => 99,  317 => 98,  313 => 96,  310 => 95,  306 => 94,  299 => 92,  293 => 91,  287 => 90,  281 => 89,  278 => 88,  275 => 87,  271 => 86,  264 => 81,  260 => 80,  256 => 79,  252 => 78,  248 => 77,  244 => 76,  240 => 75,  236 => 74,  232 => 73,  222 => 68,  220 => 67,  215 => 64,  208 => 62,  202 => 60,  200 => 59,  195 => 58,  189 => 56,  187 => 55,  184 => 54,  178 => 52,  174 => 50,  172 => 49,  167 => 47,  162 => 45,  158 => 44,  155 => 43,  149 => 41,  147 => 40,  143 => 39,  139 => 37,  135 => 36,  130 => 33,  124 => 31,  122 => 30,  117 => 29,  111 => 27,  109 => 26,  106 => 25,  102 => 24,  98 => 23,  94 => 22,  87 => 18,  79 => 16,  77 => 15,  73 => 14,  70 => 13,  66 => 12,  59 => 8,  55 => 6,  47 => 4,  45 => 3,  41 => 2,  38 => 1,);
    }

    public function getSourceContext()
    {
        return new Source("", "database/data_dictionary/index.twig", "D:\\laragon\\etc\\apps\\phpmyadmin\\templates\\database\\data_dictionary\\index.twig");
    }
}
