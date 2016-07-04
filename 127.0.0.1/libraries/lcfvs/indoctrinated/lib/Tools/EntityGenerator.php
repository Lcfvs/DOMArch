<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Indoctrinated\Tools;

use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Common\Util\Inflector;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Indoctrinated\Repository;

/**
 * A Doctrine's EntityGenerator hack
 *  - Provides an init($value) method
 *    It only sets if the property value is null
 *
 *  - Respects the column names style
 *
 *
 * @link    www.doctrine-project.org
 * @since   2.0
 * @author  Benjamin Eberlei <kontakt@beberlei.de>
 * @author  Guilherme Blanco <guilhermeblanco@hotmail.com>
 * @author  Jonathan Wage <jonwage@gmail.com>
 * @author  Roman Borschel <roman@code-factory.org>
 * @author  Lcf.vs <michael.rouges@gmail.com>
 */
class EntityGenerator
    extends \Doctrine\ORM\Tools\EntityGenerator
{
    /**
     * @var string
     */
    protected $fieldVisibility = 'protected';

    /**
     * @var string
     */
    protected static $getIdMethodTemplate =
        '/**
 * <description>
 *
 * @return <variableType>
 */
public function <methodName>()
{
<spaces>return $this-><fieldName>;
}';

    /**
     * @var string
     */
    protected static $getMethodTemplate =
        '/**
 * <description>
 *
 * @param $<variableName><variableDefault>
 *
 * @return <variableType>
 */
public function <methodName>(
<spaces>$<variableName><variableDefault>
)
{
<spaces>if ($this-><fieldName> !== null) {
<spaces><spaces>return $this-><fieldName>;
<spaces>}

<spaces>if (is_callable($<variableName>)) {
<spaces><spaces>return $<variableName>();
<spaces>}

<spaces>return $<variableName>;
}';
    /**
     * @var string
     */
    protected static $initMethodTemplate =
        '/**
 * <description>
 *
 * @param <variableType> $<variableName>
 *
 * @return <entity>
 */
public function <methodName>(
<spaces><methodTypeHint>$<variableName><variableDefault>
)
{
<spaces>if ($this-><fieldName> !== null) {
<spaces><spaces>return $this;
<spaces>}

<spaces>if (is_callable($<variableName>)) {
<spaces><spaces>return $this-><setterName>($<variableName>());
<spaces>}

<spaces>return $this-><setterName>($<variableName>);
}';
    /**
     * @var string
     */
    protected static $setMethodTemplate =
        '/**
 * <description>
 *
 * @param <variableType> $<variableName>
 *
 * @return <entity>
 */
public function <methodName>(
<spaces><methodTypeHint>$<variableName><variableDefault>
)
{
<spaces>$this-><fieldName> = $<variableName>;

<spaces>return $this;
}';

    /**
     * @var string
     */
    protected static $addMethodTemplate =
        '/**
 * <description>
 *
 * @param <variableType> $<variableName>
 *
 * @return <entity>
 */
public function <methodName>(
<spaces><methodTypeHint>$<variableName>
)
{
<spaces>$this-><fieldName>[] = $<variableName>;

<spaces>return $this;
}';

    /**
     * @var string
     */
    protected static $removeMethodTemplate =
        '/**
 * <description>
 *
 * @param <variableType> $<variableName>
 */
public function <methodName>(
<spaces><methodTypeHint>$<variableName>
)
{
<spaces>$this-><fieldName>->removeElement($<variableName>);
}';

    /**
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    protected function generateEntityStubMethods(ClassMetadataInfo $metadata)
    {
        $methods = array();

        foreach ($metadata->fieldMappings as $fieldMapping) {
            if (isset($fieldMapping['declaredField']) &&
                isset($metadata->embeddedClasses[$fieldMapping['declaredField']])
            ) {
                continue;
            }

            if (( ! isset($fieldMapping['id']) ||
                    ! $fieldMapping['id'] ||
                    $metadata->generatorType == ClassMetadataInfo::GENERATOR_TYPE_NONE
                ) && (! $metadata->isEmbeddedClass || ! $this->embeddablesImmutable)
            ) {
                if ($code = $this->generateEntityStubMethod($metadata, 'set', $fieldMapping['fieldName'], $fieldMapping['type'])) {
                    $methods[] = $code;
                }
                if ($code = $this->generateEntityStubMethod($metadata, 'init', $fieldMapping['fieldName'], $fieldMapping['type'])) {
                    $methods[] = $code;
                }
            }

            if ($code = $this->generateEntityStubMethod($metadata, 'get', $fieldMapping['fieldName'], $fieldMapping['type'])) {
                $methods[] = $code;
            }
        }

        foreach ($metadata->embeddedClasses as $fieldName => $embeddedClass) {
            if (isset($embeddedClass['declaredField'])) {
                continue;
            }

            if ( ! $metadata->isEmbeddedClass || ! $this->embeddablesImmutable) {
                if ($code = $this->generateEntityStubMethod($metadata, 'set', $fieldName, $embeddedClass['class'])) {
                    $methods[] = $code;
                }

                if ($code = $this->generateEntityStubMethod($metadata, 'init', $fieldName, $embeddedClass['class'])) {
                    $methods[] = $code;
                }
            }

            if ($code = $this->generateEntityStubMethod($metadata, 'get', $fieldName, $embeddedClass['class'])) {
                $methods[] = $code;
            }
        }

        foreach ($metadata->associationMappings as $associationMapping) {
            if ($associationMapping['type'] & ClassMetadataInfo::TO_ONE) {
                $nullable = $this->isAssociationIsNullable($associationMapping) ? 'null' : null;
                if ($code = $this->generateEntityStubMethod($metadata, 'set', $associationMapping['fieldName'], $associationMapping['targetEntity'], $nullable)) {
                    $methods[] = $code;
                }
                if ($code = $this->generateEntityStubMethod($metadata, 'init', $associationMapping['fieldName'], $associationMapping['targetEntity'], $nullable)) {
                    $methods[] = $code;
                }
                if ($code = $this->generateEntityStubMethod($metadata, 'get', $associationMapping['fieldName'], $associationMapping['targetEntity'])) {
                    $methods[] = $code;
                }
            } elseif ($associationMapping['type'] & ClassMetadataInfo::TO_MANY) {
                if ($code = $this->generateEntityStubMethod($metadata, 'add', $associationMapping['fieldName'], $associationMapping['targetEntity'])) {
                    $methods[] = $code;
                }
                if ($code = $this->generateEntityStubMethod($metadata, 'remove', $associationMapping['fieldName'], $associationMapping['targetEntity'])) {
                    $methods[] = $code;
                }
                if ($code = $this->generateEntityStubMethod($metadata, 'get', $associationMapping['fieldName'], 'Doctrine\Common\Collections\Collection')) {
                    $methods[] = $code;
                }
            }
        }

        return implode("\n\n", $methods);
    }

    /**
     * @param ClassMetadataInfo $metadata
     * @param string            $type
     * @param string            $fieldName
     * @param string|null       $typeHint
     * @param string|null       $defaultValue
     *
     * @return string
     */
    protected function generateEntityStubMethod(ClassMetadataInfo $metadata, $type, $fieldName, $typeHint = null,  $defaultValue = null)
    {
        $methodName = $type . Inflector::classify($fieldName);
        $variableName = Inflector::camelize($fieldName);
        if (in_array($type, array("add", "remove"))) {
            $methodName = Inflector::singularize($methodName);
            $variableName = Inflector::singularize($variableName);
        }

        if ($this->hasMethod($methodName, $metadata)) {
            return '';
        }
        $this->staticReflection[$metadata->name]['methods'][] = strtolower($methodName);

        $var = sprintf('%s%sMethodTemplate', $type, $variableName === 'id' ? 'Id' : '');
        $template = static::$$var;

        $methodTypeHint = null;
        $types          = Type::getTypesMap();
        $variableType   = $typeHint ? $this->getType($typeHint) : null;

        if ($typeHint && ! isset($types[$typeHint])) {
            $variableType   =  '\\' . ltrim($variableType, '\\');
            $methodTypeHint =  '\\' . $typeHint . ' ';
        }

        $columnName = $variableName;
        $naming_strategy = new UnderscoreNamingStrategy();
        $variableName = $naming_strategy->propertyToColumnName($variableName);

        $replacements = array(
            '<description>'       => ucfirst($type) . ' ' . $columnName,
            '<methodTypeHint>'    => $methodTypeHint,
            '<variableType>'      => $variableType,
            '<variableName>'      => $variableName,
            '<methodName>'        => $methodName,
            '<fieldName>'         => $fieldName,
            '<variableDefault>'   => ($defaultValue !== null || $type === 'get') ? (' = '.($defaultValue ?? 'null')) : '',
            '<entity>'            => $this->getClassName($metadata)
        );

        if ($type === 'init') {
            $replacements['<setterName>'] = 'set' . ucfirst($columnName);
        }

        $method = str_replace(
            array_keys($replacements),
            array_values($replacements),
            $template
        );

        return $this->prefixCodeWithSpaces($method);
    }

    /**
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    protected function generateEntityFieldMappingProperties(ClassMetadataInfo $metadata)
    {
        $lines = array();

        foreach ($metadata->fieldMappings as $fieldMapping) {
            if ($this->hasProperty($fieldMapping['columnName'], $metadata) ||
                $metadata->isInheritedField($fieldMapping['columnName']) ||
                (
                    isset($fieldMapping['declaredField']) &&
                    isset($metadata->embeddedClasses[$fieldMapping['declaredField']])
                )
            ) {
                continue;
            }

            $lines[] = $this->generateFieldMappingPropertyDocBlock($fieldMapping, $metadata);
            $lines[] = $this->spaces . $this->fieldVisibility . ' $' . $fieldMapping['columnName']
                . (isset($fieldMapping['options']['default']) ? ' = ' . var_export($fieldMapping['options']['default'], true) : null) . ";\n";
        }

        return implode("\n", $lines);
    }

    /**
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    protected function generateEntityAnnotation(ClassMetadataInfo $metadata)
    {
        $prefix = '@' . $this->annotationsPrefix;

        if ($metadata->isEmbeddedClass) {
            return $prefix . 'Embeddable';
        }

        // todo remove this hack

        $metadata->customRepositoryClassName = 'Repositories\\' . $this->getClassName($metadata);

        $customRepository = $metadata->customRepositoryClassName
            ? '(repositoryClass="' . $metadata->customRepositoryClassName . '")'
            : '';

        return $prefix . ($metadata->isMappedSuperclass ? 'MappedSuperclass' : 'Entity') . $customRepository;
    }

    /**
     * @param ClassMetadataInfo $metadata
     *
     * @return string
     */
    protected function generateEntityBody(ClassMetadataInfo $metadata)
    {
        $fieldMappingProperties = $this->generateEntityFieldMappingProperties($metadata);
        $embeddedProperties = $this->generateEntityEmbeddedProperties($metadata);
        $associationMappingProperties = $this->generateEntityAssociationMappingProperties($metadata);
        $stubMethods = $this->generateEntityStubMethods ? $this->generateEntityStubMethods($metadata) : null;
        $lifecycleCallbackMethods = $this->generateEntityLifecycleCallbackMethods($metadata);

        $code = array();

        if ($fieldMappingProperties) {
            $code[] = $fieldMappingProperties;
        }

        if ($embeddedProperties) {
            $code[] = $embeddedProperties;
        }

        if ($associationMappingProperties) {
            $code[] = $associationMappingProperties;
        }

        $code[] = $this->generateEntityConstructor($metadata);

        if ($stubMethods) {
            $code[] = $stubMethods;
        }

        if ($lifecycleCallbackMethods) {
            $code[] = $lifecycleCallbackMethods;
        }

        return implode("\n", $code);
    }
}
