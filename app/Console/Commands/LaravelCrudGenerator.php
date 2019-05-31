<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class LaravelCrudGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lara:crud {name : Class (singular), e.g User}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Laravel Crud Generator';

    /**
     * The default namespace for Controller / Model / Request / Filter.
     *
     * @var string
     */
    protected $namespace = 'Generator';

    /**
     * The default application route file
     *
     * @var string
     */
    protected $route_file = 'web.php';

    /**
     * The default namespace application route
     *
     * @var string
     */
    protected $route_namespace = 'generator';

    /**
     * The default namespace blade folder
     *
     * @var string
     */
    protected $view_namespace = 'generators';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->generateController($name);
        $this->generateModel($name);
        $this->generateRequest($name);
        $this->generateResource($name);
        $this->generateFilter($name);
        $this->generateBlade($name);
        $this->generateVueComponent($name);

        $this->writeRoute($name);
    }

    protected function getStub($type)
    {
        return file_get_contents(resource_path("stubs/generator/$type.stub"));
    }

    protected function generateModel($name)
    {
        $modelTemplate = $this->getTemplate($name, 'Model');

        file_put_contents(app_path("Models/" . $this->getNamespace() . "/{$name}.php"), $modelTemplate);
    }

    protected function generateController($name)
    {
        $controllerTemplate = $this->getTemplate($name, 'Controller');

        file_put_contents(app_path("/Http/Controllers/" . $this->getNamespace() . "/{$name}Controller.php"), $controllerTemplate);
    }

    protected function generateRequest($name)
    {
        $this->writeStoreRequest($name);
        $this->writeUpdateRequest($name);
    }

    protected function generateResource($name)
    {
        $resourceTemplate = $this->getTemplate($name, 'Resource');

        file_put_contents(app_path("Http/Resources/" . $this->getNamespace() . "/{$name}Resource.php"), $resourceTemplate);
    }

    protected function generateFilter($name)
    {
        $filterTemplate = $this->getTemplate($name, 'Filter');

        file_put_contents(app_path("Filters/" . $this->getNamespace() . "/{$name}Filter.php"), $filterTemplate);
    }

    protected function generateBlade($name)
    {
        $this->writeIndexBlade($name);
        $this->writeCreateBlade($name);
        $this->writeEditBlade($name);
    }

    protected function generateVueComponent($name)
    {
        $this->writeIndexComponent($name);
        $this->writeCreateComponent($name);
        $this->writeEditComponent($name);
    }

    protected function writeStoreRequest($name)
    {
        $requestTemplate = $this->getTemplate($name, 'StoreRequest');

        if(!file_exists($path = app_path('/Http/Requests/' . $this->getNamespace())))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/" . $this->getNamespace() . "/Store{$name}Request.php"), $requestTemplate);
    }

    protected function writeUpdateRequest($name)
    {
        $requestTemplate = $this->getTemplate($name, 'UpdateRequest');

        if(!file_exists($path = app_path('/Http/Requests/' . $this->getNamespace())))
            mkdir($path, 0777, true);

        file_put_contents(app_path("/Http/Requests/" . $this->getNamespace() . "/Update{$name}Request.php"), $requestTemplate);
    }

    protected function writeIndexBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'IndexBlade');

        if(!file_exists($path = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)))))
            mkdir($path, 0777, true);

        file_put_contents(resource_path("views/" . $this->getViewNamespace() . "/" . strtolower(str_plural($name)) . "/index.blade.php"), $bladeTemplate);
    }

    protected function writeCreateBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'CreateBlade');

        if(!file_exists($path = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)))))
            mkdir($path, 0777, true);

        file_put_contents(resource_path("views/" . $this->getViewNamespace() . "/" . strtolower(str_plural($name)) . "/create.blade.php"), $bladeTemplate);
    }

    protected function writeEditBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'EditBlade');

        if(!file_exists($path = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)))))
            mkdir($path, 0777, true);

        file_put_contents(resource_path("views/" . $this->getViewNamespace() . "/" . strtolower(str_plural($name)) . "/edit.blade.php"), $bladeTemplate);
    }

    protected function writeIndexComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'IndexComponentVue');

        if(!file_exists($path = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)))))
            mkdir($path, 0777, true);

        file_put_contents(resource_path("components/" . $this->getViewNamespace() . "/" . strtolower(str_plural($name)) . "/Index{$name}Component.vue"), $vueTemplate);
    }

    protected function writeCreateComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'CreateComponentVue');

        if(!file_exists($path = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)))))
            mkdir($path, 0777, true);

        file_put_contents(resource_path("components/" . $this->getViewNamespace() . "/" . strtolower(str_plural($name)) . "/Create{$name}Component.vue"), $vueTemplate);
    }

    protected function writeEditComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'EditComponentVue');

        if(!file_exists($path = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)))))
            mkdir($path, 0777, true);

        file_put_contents(resource_path("components/" . $this->getViewNamespace() . "/" . strtolower(str_plural($name)) . "/Edit{$name}Component.vue"), $vueTemplate);
    }

    protected function writeRoute($name)
    {
        $routes = $this->getRoutes($name);

        File::append(base_path('routes/' . $this->getRouteFile()), $routes);
    }

    protected function getTemplate($name, $stub)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{routeNamespace}}',
                '{{namespace}}',
            ],
            [
                $name,
                str_plural($name),
                strtolower(str_plural($name)),
                strtolower($name),
                $this->getRouteNamespace(),
                $this->getNamespace()
            ],
            $this->getStub($stub)
        );

        return $template;
    }

    protected function getRoutes($name)
    {
        $routes = 'Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');";

        return $routes;
    }

    protected function getNamespace()
    {
        return $this->namespace;
    }

    protected function getRouteFile()
    {
        return $this->route_file;
    }

    protected function getRouteNamespace()
    {
        return $this->route_namespace;
    }

    protected function getViewNamespace()
    {
        return $this->view_namespace;
    }
}
