<?php

namespace DkDev\Testrine\Generators;

use DkDev\Testrine\Generators\Stubs\BaseClass\AuthMethodsStub;
use DkDev\Testrine\Generators\Stubs\BaseClass\RouteStub;
use DkDev\Testrine\Generators\Stubs\BaseClass\SendInvalidParametersStub;
use DkDev\Testrine\Generators\Stubs\BaseClass\SendNotValidDataStub;
use DkDev\Testrine\Generators\Stubs\BaseClassStub;
use DkDev\Testrine\Helpers\Stub;
use DkDev\Testrine\Inform\Inform;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

/**
 * @method static BaseClassGenerator make(string $group)
 */
class BaseClassGenerator extends BaseGenerator
{
    use Makeable;

    public function __construct(
        protected string $group,
    ) {
        parent::__construct();
    }

    public function getStubs(): array
    {
        return [
            AuthMethodsStub::class,
            RouteStub::class,
            SendInvalidParametersStub::class,
            SendNotValidDataStub::class,
        ];
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @throws FileNotFoundException
     */
    public function generate(): void
    {
        $searches = ['{{ class_name }}', '{{ group }}'];
        $replaces = [$this->getClassName(), $this->getStudlyGroup()];

        /** @var BaseClassStub $stub */
        foreach ($this->stubs as $stub) {
            $searches[] = $stub->getReplacementKey();
            $replaces[] = $stub->getReplacementValue();
        }

        $stub = str_replace($searches, $replaces, Stub::getStub('base_class.class'));

        File::ensureDirectoryExists(path: dirname($this->getClassPath()));

        File::put(path: $this->getClassPath(), contents: $stub);

        $this->pushInform();
    }

    protected function getClassName(): string
    {
        return 'Base'.$this->getStudlyGroup().'TestCase';
    }

    protected function getClassPath(): string
    {
        $dr = DIRECTORY_SEPARATOR;

        return "tests{$dr}Feature$dr{$this->getStudlyGroup()}$dr{$this->getClassName()}.php";
    }

    protected function pushInform(): void
    {
        Inform::push(
            message: __('testrine::console.init.info', [
                'group' => str($this->group)->ucfirst(),
                'class' => $this->getClassPath(),
            ]),
            prependIndent: true
        );
    }
}
