<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\Artisan;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CrudGeneratorCommand extends Command
{
    protected $signature = 'crud:generator
    {name : Class (singular) for example User} {--table=} {--fields=*}';

    protected $description = 'Create crud operations';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $tableName = $this->option('table');
        $fields = $this->option('fields');
        $properties = $this->gerarProperties($fields);
        $string_array_fields = $this->gerarArrayFields($fields);
        $resource_fields = $this->gerarResourceFields($fields);
        $this->controller($name,$properties);
        $this->service($name);
        $this->repository($name);
        $this->model($name, $fields, $tableName);
        $this->request($name);
        #$this->test($name,$string_array_fields);
        $this->factory($name,$string_array_fields);
        #$this->resource($name,$resource_fields);
        $this->resourceCollection($name);

        $nameController = $name . "Controller";

        File::append(base_path('routes/api.php'), "\n \n Route::apiResource('" .  Str::plural(Str::snake($name, '-')) . "'" . str_replace(".", "", ",App\Http\Controllers\.$nameController.::class)") . "->middleware(['check.auth'])->parameters(['". Str::plural(Str::snake($name, '-'))."' => 'id']);");

      // Artisan::call(command: 'make:test ' . $name . 'Test');

      //Artisan::call(command: 'make:factory ' . $name . 'Factory --model=' . $name);

    }

    protected function controller($name,$properties)
    {
        $controllerTemplate = str_replace(
            [
                '{{modelName}}',
                '{{properties}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                $properties,
                strtolower(Str::plural($name)),
                strtolower(Str::snake($name))
            ],
            $this->getStub('Controller')
        );

        if (!file_exists($path = app_path("/Http/Controllers")))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Controllers/{$name}Controller.php"), $controllerTemplate);
    }
    protected function service($name)
    {
        $serviceTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                 strtolower(Str::snake($name))
            ],
            $this->getStub('Service')
        );

        if (!file_exists($path = app_path("/Services")))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Services/{$name}Service.php"), $serviceTemplate);
    }

    protected function repository($name)
    {
        $repositoryTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                 strtolower(Str::snake($name))
            ],
            $this->getStub('Repository')
        );

        if (!file_exists($path = app_path("/Repositories")))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Repositories/{$name}Repository.php"), $repositoryTemplate);
    }

    protected function model($name, $fields, $tableName)
    {
        $modelTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Model')
        );
        $fields = '"' . implode('","', $fields) . '"';
        $modelTemplate = str_replace(
            ['{{fillable}}'],
            [$fields],
            $modelTemplate
        );
        $modelTemplate = str_replace(
            ['{{tableName}}'],
            [$tableName],
            $modelTemplate
        );

        if (!file_exists($path = app_path("/Models")))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Models/{$name}.php"), $modelTemplate);
    }

    protected function request($name)
    {
        $requestTemplate = str_replace(
            ['{{modelName}}'],
            [$name],
            $this->getStub('Request')
        );


        if (!file_exists($path = app_path('/Http/Requests')))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/{$name}Request.php"), $requestTemplate);
    }

    protected function test($name,$string_array_fields){

        $testTemplate = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelnamesingularlowercase}}',
                '{{arrayfields}}'
            ],
            [
                $name,
                strtolower(Str::plural($name)),
                strtolower(Str::snake($name)),
                $string_array_fields
            ],
            $this->getStub('Test')
        );

        if (!file_exists($path = base_path("tests/Feature")))
            mkdir($path, 0777, true);

        file_put_contents(base_path("tests/Feature/{$name}Test.php"), $testTemplate);
    }

    protected function factory($name,$string_array_fields){

        $factoryTemplate = str_replace(
            [
                '{{modelName}}',
                '{{arrayfields}}'
            ],
            [
                $name,
                $string_array_fields
            ],
            $this->getStub('Factory')
        );

        if (!file_exists($path = base_path("database/factories")))
            mkdir($path, 0777, true);

        file_put_contents(base_path("database/factories/{$name}Factory.php"), $factoryTemplate);
    }

    protected function resource($name,$string_array_fields){

        $resourceTemplate = str_replace(
            [
                '{{modelName}}',
                '{{arrayfields}}'
            ],
            [
                $name,
                $string_array_fields
            ],
            $this->getStub('Resource')
        );

        if (!file_exists($path = app_path("/Http/Resources")))
        mkdir($path, 0777, true);

    file_put_contents(app_path("/Http/Resources/{$name}Resource.php"), $resourceTemplate);
    }

    protected function resourceCollection($name){

        $resourceTemplate = str_replace(
            [
                '{{modelName}}'
            ],
            [
                $name
            ],
            $this->getStub('Collection')
        );

        if (!file_exists($path = app_path("/Http/Resources")))
        mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Resources/{$name}Collection.php"), $resourceTemplate);
    }


    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/$type.stub"));
    }

    public function gerarProperties($fields)
    {
        $propety = '';
        foreach ($fields as  $field) {
            $propety .= "\n" ."\t\t" ."*"."\t". '@OA\Property(property="' . $field . '"),';
        }
        return $propety;
    }

    public function gerarArrayFields($fields)
    {
        $string_array = '';
        foreach ($fields as  $field) {
            $string_array .= "\n" . "\t\t\t" . "'" . $field . "' => '',";
        }
        return $string_array;
    }

    public function gerarResourceFields($fields)
    {
        $string_array = '';
        foreach ($fields as  $field) {
            $string_array .= "\n" ."\t\t\t" . "'" . $field . "' =>" . "\$this->". $field .",";
        }
        return $string_array;
    }
}
