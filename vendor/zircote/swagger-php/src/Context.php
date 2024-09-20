<?php declare(strict_types=1);

/**
 * @license Apache 2.0
 */

namespace OpenApi;

use OpenApi\Logger\DefaultLogger;

/**
 * Context.
 *
 * The context in which the annotation is parsed.
 * It includes useful metadata which the Processors can use to augment the annotations.
 *
 * Context hierarchy:
 * - parseContext
 *   |- docBlockContext
 *   |- classContext
 *      |- docBlockContext
 *      |- propertyContext
 *      |- methodContext
 *
 * @property string                           $comment     The PHP DocComment
 * @property string                           $filename
 * @property int                              $line
 * @property int                              $character
 * @property string                           $namespace
 * @property array                            $uses
 * @property string                           $class
 * @property array|string                     $extends     Interfaces may extend a list of interfaces
 * @property array                            $implements
 * @property string                           $method
 * @property string                           $property
 * @property string                           $type
 * @property string                           $trait
 * @property string                           $interface
 * @property bool                             $static      Indicate a static method
 * @property bool                             $nullable    Indicate a nullable value
 * @property bool                             $generated   Indicate the context was generated by a processor or the serializer
 * @property Annotations\AbstractAnnotation   $nested
 * @property Annotations\AbstractAnnotation[] $annotations
 * @property \Psr\Log\LoggerInterface         $logger      Guaranteed to be set when using the `Generator`
 */
#[\AllowDynamicProperties]
class Context
{
    /**
     * Prototypical inheritance for properties.
     *
     * @var Context
     */
    private $_parent;

    /**
     * @param array   $properties new properties for this context
     * @param Context $parent     The parent context
     */
    public function __construct(array $properties = [], ?Context $parent = null)
    {
        foreach ($properties as $property => $value) {
            $this->$property = $value;
        }
        $this->_parent = $parent;

        if (!$this->logger) {
            // BC
            $this->logger = new DefaultLogger();
        }
    }

    /**
     * Check if a property is set directly on this context and not its parent context.
     *
     * @param string $type Example: $c->is('method') or $c->is('class')
     */
    public function is(string $type): bool
    {
        return property_exists($this, $type);
    }

    /**
     * Check if a property is NOT set directly on this context and but its parent context.
     *
     * @param string $type Example: $c->not('method') or $c->not('class')
     */
    public function not(string $type): bool
    {
        return property_exists($this, $type) === false;
    }

    /**
     * Return the context containing the specified property.
     */
    public function with(string $property): ?Context
    {
        if (property_exists($this, $property)) {
            return $this;
        }
        if ($this->_parent !== null) {
            return $this->_parent->with($property);
        }

        return null;
    }

    public function getRootContext(): Context
    {
        if ($this->_parent !== null) {
            return $this->_parent->getRootContext();
        }

        return $this;
    }

    /**
     * Export location for debugging.
     *
     * @return string Example: "file1.php on line 12"
     */
    public function getDebugLocation(): string
    {
        $location = '';
        if ($this->class && ($this->method || $this->property)) {
            $location .= $this->fullyQualifiedName($this->class);
            if ($this->method) {
                $location .= ($this->static ? '::' : '->') . $this->method . '()';
            } elseif ($this->property) {
                $location .= ($this->static ? '::$' : '->') . $this->property;
            }
        }
        if ($this->filename) {
            if ($location !== '') {
                $location .= ' in ';
            }
            $location .= $this->filename;
        }
        if ($this->line) {
            if ($location !== '') {
                $location .= ' on';
            }
            $location .= ' line ' . $this->line;
            if ($this->character) {
                $location .= ':' . $this->character;
            }
        }

        return $location;
    }

    /**
     * Traverse the context tree to get the property value.
     *
     * @param string $property
     */
    public function __get($property)
    {
        if ($this->_parent !== null) {
            return $this->_parent->$property;
        }

        return null;
    }

    public function __toString()
    {
        return $this->getDebugLocation();
    }

    public function __debugInfo()
    {
        return ['-' => $this->getDebugLocation()];
    }

    /**
     * A short piece of text, usually one line, providing the basic function of the associated element.
     *
     * @return string
     */
    public function phpdocSummary()
    {
        $content = $this->phpdocContent();
        if (!$content) {
            return Generator::UNDEFINED;
        }
        $lines = preg_split('/(\n|\r\n)/', $content);
        $summary = '';
        foreach ($lines as $line) {
            $summary .= $line . "\n";
            if ($line === '' || substr($line, -1) === '.') {
                return trim($summary);
            }
        }
        $summary = trim($summary);
        if ($summary === '') {
            return Generator::UNDEFINED;
        }

        return $summary;
    }

    /**
     * An optional longer piece of text providing more details on the associated element’s function. This is very useful when working with a complex element.
     *
     * @return string
     */
    public function phpdocDescription()
    {
        $summary = $this->phpdocSummary();
        if (!$summary) {
            return Generator::UNDEFINED;
        }
        if (false !== ($substr = substr($this->phpdocContent(), strlen($summary)))) {
            $description = trim($substr);
        } else {
            $description = '';
        }
        if ($description === '') {
            return Generator::UNDEFINED;
        }

        return $description;
    }

    /**
     * The text contents of the phpdoc comment (excl. tags).
     *
     * @return string
     */
    public function phpdocContent()
    {
        $comment = preg_split('/(\n|\r\n)/', (string) $this->comment);
        $comment[0] = preg_replace('/[ \t]*\\/\*\*/', '', $comment[0]); // strip '/**'
        $i = count($comment) - 1;
        $comment[$i] = preg_replace('/\*\/[ \t]*$/', '', $comment[$i]); // strip '*/'
        $lines = [];
        $append = false;
        foreach ($comment as $line) {
            $line = ltrim($line, "\t *");
            if (substr($line, 0, 1) === '@') {
                break;
            }
            if ($append) {
                $i = count($lines) - 1;
                $lines[$i] = substr($lines[$i], 0, -1) . $line;
            } else {
                $lines[] = $line;
            }
            $append = (substr($line, -1) === '\\');
        }
        $description = trim(implode("\n", $lines));
        if ($description === '') {
            return Generator::UNDEFINED;
        }

        return $description;
    }

    /**
     * Create a Context based on the debug_backtrace.
     *
     * @deprecated
     */
    public static function detect(int $index = 0): Context
    {
        $context = new Context();
        $backtrace = debug_backtrace();
        $position = $backtrace[$index];
        if (isset($position['file'])) {
            $context->filename = $position['file'];
        }
        if (isset($position['line'])) {
            $context->line = $position['line'];
        }
        $caller = isset($backtrace[$index + 1]) ? $backtrace[$index + 1] : null;
        if (isset($caller['function'])) {
            $context->method = $caller['function'];
            if (isset($caller['type']) && $caller['type'] === '::') {
                $context->static = true;
            }
        }
        if (isset($caller['class'])) {
            $fqn = explode('\\', $caller['class']);
            $context->class = array_pop($fqn);
            if (count($fqn)) {
                $context->namespace = implode('\\', $fqn);
            }
        }

        // @todo extract namespaces and use statements
        return $context;
    }

    /**
     * Resolve the fully qualified name.
     *
     * @param string $source The source name (class/interface/trait)
     */
    public function fullyQualifiedName(?string $source): string
    {
        if ($source === null) {
            return '';
        }

        if ($this->namespace) {
            $namespace = str_replace('\\\\', '\\', '\\' . $this->namespace . '\\');
        } else {
            // global namespace
            $namespace = '\\';
        }

        $thisSource = $this->class ?? $this->interface ?? $this->trait;
        if ($thisSource && strcasecmp($source, $thisSource) === 0) {
            return $namespace . $thisSource;
        }
        $pos = strpos($source, '\\');
        if ($pos !== false) {
            if ($pos === 0) {
                // Fully qualified name (\Foo\Bar)
                return $source;
            }
            // Qualified name (Foo\Bar)
            if ($this->uses) {
                foreach ($this->uses as $alias => $aliasedNamespace) {
                    $alias .= '\\';
                    if (strcasecmp(substr($source, 0, strlen($alias)), $alias) === 0) {
                        // Aliased namespace (use \Long\Namespace as Foo)
                        return '\\' . $aliasedNamespace . substr($source, strlen($alias) - 1);
                    }
                }
            }
        } elseif ($this->uses) {
            // Unqualified name (Foo)
            foreach ($this->uses as $alias => $aliasedNamespace) {
                if (strcasecmp($alias, $source) === 0) {
                    return '\\' . $aliasedNamespace;
                }
            }
        }

        return $namespace . $source;
    }
}
