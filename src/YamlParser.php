<?php namespace Sujan\Yaml;

use Symfony\Component\Yaml\Parser;

/**
 * Yaml Parser helper class
 */
class YamlParser
{
    /**
     * Parses supplied YAML contents in to a PHP array.
     * @param string $contents YAML contents to parse.
     * @return array The YAML contents as an array.
     */
    public function parse($contents)
    {
        $yaml = new Parser;
        return $yaml->parse($contents);
    }

    /**
     * Parses YAML file contents in to a PHP array.
     * @param string $fileName File to read contents and parse.
     * @return array The YAML contents as an array.
     */
    public function parseFile($fileName)
    {
        $contents = file_get_contents($fileName);
        return json_decode(json_encode($this->parse($contents)));
    }
}
