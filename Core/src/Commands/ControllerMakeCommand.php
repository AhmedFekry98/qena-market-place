<?php

namespace Graphicode\Features\Commands;

use PHPUnit\Runner\ParameterDoesNotExistException;
use Symfony\Component\Console\Input\InputOption;

class ControllerMakeCommand extends BaseCommand
{

    protected $name = "feature:make-controller";

    public function handle()
    {
        if (parent::handle() == false) {
            return false;
        }
    }

    protected function getStub(): string
    {
        if ($this->option('invokable')) {
            return 'controller.invokable.stub';
        }

        return 'controller.api.stub';
    }

    protected function qualifyName(string $name): string
    {
        return '/Controllers/' . parent::qualifyName($name) . '.php';
    }

    protected function getReplacments(): array
    {
        $class = parent::qualifyName($this->getNameInput());

        return [
            'namespace' => $this->getRootNamespace() . 'Controllers',
            'class'     => $class
        ];
    }

    public function getOptions(): array
    {
        return [
            ['--force'       ],
            ['--invokable'   ]
        ];
    }
}
