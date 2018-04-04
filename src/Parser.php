<?php namespace Sujan\LaraForm;

use Symfony\Component\Yaml\Parser as SymfonyParser;

/**
 * Yaml Parser helper class
 */
class Parser
{
    /**
     * Parses supplied YAML contents in to a PHP array.
     * @param string $contents YAML contents to parse.
     * @return array The YAML contents as an array.
     */
    public function parse($contents)
    {
        $yaml = new SymfonyParser();
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
