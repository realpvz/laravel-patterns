<?php

namespace Realpvz\Services\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeServiceCommand extends GeneratorCommand
{
    protected $name = 'make:service';

    protected $description = 'Create a new service class';

    protected $type = 'Service';

    protected $className;

    public function handle()
    {
        $className = $this->checkFormat($this->argument('name'));
        $this->className = $className;
        parent::handle();
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput(): string
    {
        return trim($this->className);
    }

    /**
     * @param $str
     * @return string
     */
    protected function checkFormat($str): string
    {
        $result = Str::ucsplit($str);

        if (in_array($this->type, $result)) {
            return $str;
        }

        return $str.$this->type;
    }

    protected function getStub(): string
    {
        $stubPath = '../Stubs/service.stub';
        $customPath = $this->laravel->basePath('stubs/service.stub');
        return file_exists($customPath) ? $customPath : $stubPath;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Services';
    }


    /**
     * @return string
     */
    private function getClassFqn(): string
    {
        return $this->qualifyClass($this->getNameInput());
    }

    /**
     * @param string $value
     *
     * @return string|string[]
     */
    private function replaceClassFqn(string $value)
    {
        return str_replace(
            '{{classFQN}}',
            $this->getClassFqn(),
            $value
        );
    }

    /**
     * @param string $value
     *
     * @return string|string[]
     */
    private function replaceServiceName(string $value)
    {
        return str_replace(
            '{{serviceName}}',
            $this->getNameInput(),
            $value
        );
    }
}
