<?php

namespace DkDev\Testrine\Generators;

use DkDev\Testrine\Exceptions\TestAlreadyExistException;
use DkDev\Testrine\Generators\Stubs\TestClass\CodesStub;
use DkDev\Testrine\Generators\Stubs\TestClass\InvalidateStub;
use DkDev\Testrine\Generators\Stubs\TestClass\InvalidCodeStub;
use DkDev\Testrine\Generators\Stubs\TestClass\InvalidParametersCodeStub;
use DkDev\Testrine\Generators\Stubs\TestClass\InvalidParametersStub;
use DkDev\Testrine\Generators\Stubs\TestClass\JobStub;
use DkDev\Testrine\Generators\Stubs\TestClass\MockStub;
use DkDev\Testrine\Generators\Stubs\TestClass\NotificationStub;
use DkDev\Testrine\Generators\Stubs\TestClass\ParametersStub;
use DkDev\Testrine\Generators\Stubs\TestClass\ResponseStub;
use DkDev\Testrine\Generators\Stubs\TestClass\RouteMiddlewareStub;
use DkDev\Testrine\Generators\Stubs\TestClass\SeedStub;
use DkDev\Testrine\Generators\Stubs\TestClass\ValidateStub;
use DkDev\Testrine\Generators\Stubs\TestClassStub;
use DkDev\Testrine\Helpers\Char;
use DkDev\Testrine\Helpers\Stub;
use DkDev\Testrine\Inform\Inform;
use DkDev\Testrine\Traits\Makeable;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

/**
 * @method static TestGenerator make(string $className, array $contracts, string $routeName, string $middlewares, string $group, bool $rewrite)
 */
class TestGenerator extends BaseGenerator
{
    use Makeable;

    protected string $path;

    protected string $preparedGroup;

    public function __construct(
        public string $className,
        public array $contracts,
        public string $routeName,
        public string $middlewares,
        public string $group,
        public bool $rewrite,
    ) {
        parent::__construct();
    }

    public function getStubs(): array
    {
        return [
            RouteMiddlewareStub::class,
            CodesStub::class,
            InvalidCodeStub::class,
            InvalidParametersCodeStub::class,
            InvalidParametersStub::class,
            ParametersStub::class,
            JobStub::class,
            MockStub::class,
            NotificationStub::class,
            SeedStub::class,
            ValidateStub::class,
            InvalidateStub::class,
            ResponseStub::class,
        ];
    }

    public function getGroup(): string
    {
        return $this->group;
    }

    public function prepareGroup(): void
    {
        $this->preparedGroup = str($this->group)->lower()->studly();
    }

    /**
     * @throws TestAlreadyExistException
     * @throws FileNotFoundException
     */
    public function generate(): void
    {
        $this->prepareGroup();
        $this->classNameUpdate();
        $this->setPath();

        $keys = [
            '{{ namespace }}',
            '{{ extendsClass }}',
            '{{ uses }}',
            '{{ class }}',
            '{{ implements }}',
            '{{ methods }}',
        ];

        $values = [
            trim($this->getNamespace()),
            $this->getExtendsClass(),
            $this->getUses(),
            trim($this->getClassName()),
            $this->getImplements(),
            $this->getMethods(),
        ];

        $this->saveClass(
            str_replace($keys, $values, Stub::getStub('test.class'))
        );
    }

    protected function getNamespace(): string
    {
        if (Str::contains($this->className, '/')) {
            return "Tests\\Feature\\$this->preparedGroup\\".str($this->className)->beforeLast('/')->replace('/', '\\');
        }

        return "Tests\\Feature\\$this->preparedGroup\\";
    }

    protected function getExtendsClass(): string
    {
        return "Base{$this->preparedGroup}TestCase";
    }

    protected function getUses(): string
    {
        $uses = "use Tests\\Feature\\$this->preparedGroup\\{$this->getExtendsClass()};\n";

        foreach ($this->contracts as $contract) {
            $uses .= 'use '.$contract.";\n";
        }

        return rtrim($uses, Char::NL);
    }

    protected function getClassName(): string
    {
        if (Str::contains($this->className, '/')) {
            return Str::afterLast($this->className, '/');
        }

        return $this->className;
    }

    protected function getImplements(): string
    {
        if (! count($this->contracts)) {
            return '';
        }

        $implements = 'implements ';

        foreach ($this->contracts as $contract) {
            $implements .= Str::afterLast($contract, '\\').', ';
        }

        return rtrim($implements, ', ');
    }

    protected function getMethods(): string
    {
        $methods = [];

        /** @var TestClassStub $stub */
        foreach ($this->stubs as $stub) {
            if ($stub->needUse()) {
                $methods[] = $stub->getReplacementValue();
            }
        }

        return preg_replace('/'.Char::NL.'{3,}/', Char::NL2, trim(implode(Char::NL2, $methods)));
    }

    protected function setPath(): void
    {
        $ds = DIRECTORY_SEPARATOR;

        $this->path = "tests{$ds}Feature$ds$this->preparedGroup$ds".
            str($this->className)->replace('/', $ds)->value().'.php';
    }

    /**
     * @throws TestAlreadyExistException
     */
    protected function saveClass(string $stub): void
    {
        $fileExist = File::exists($this->path);

        if (! $this->rewrite && $fileExist) {
            throw (new TestAlreadyExistException)->setPath($this->path);
        }

        if (! File::isDirectory(dirname($this->path))) {
            File::makeDirectory(dirname($this->path), 0777, true);
        }

        File::put($this->path, $stub);

        Inform::push(
            message: $fileExist
                ? __('testrine::console.make.rewrite_success', ['path' => $this->path])
                : __('testrine::console.make.write_success', ['path' => $this->path]),
            appendIndent: true,
        );
    }

    protected function ClassNameUpdate(): void
    {
        $this->className = str($this->className)->replace('\\', '/');

        $last = str($this->className)->afterLast('/');

        if (! $last->endsWith('Test') && ! $last->endsWith('test')) {
            $this->className .= 'Test';
        } elseif ($last->endsWith('test')) {
            $this->className = str($this->className)->replaceLast('test', 'Test');
        }
    }
}
