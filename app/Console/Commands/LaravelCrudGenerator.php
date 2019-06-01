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

        $this->generateModel($name);
        $this->generateController($name);
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

        $folderPath = app_path('Models/' . $this->getNamespace());

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/{$name}.php";

        file_put_contents($filePath, $modelTemplate);

        $this->info("$filePath generated");
    }

    protected function generateController($name)
    {
        $controllerTemplate = $this->getTemplate($name, 'Controller');

        $folderPath = app_path('Http/Controllers/' . $this->getNamespace());

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/{$name}Controller.php";

        file_put_contents($filePath, $controllerTemplate);

        $this->info("$filePath generated");
    }

    protected function generateRequest($name)
    {
        $this->writeStoreRequest($name);
        $this->writeUpdateRequest($name);
    }

    protected function generateResource($name)
    {
        $resourceTemplate = $this->getTemplate($name, 'Resource');

        $folderPath = app_path('Http/Resources/' . $this->getNamespace());

        $this->makeDirIfNotExist(app_path('Http/Resources/' . $this->getNamespace()));

        $filePath = $folderPath . "/{$name}Resource.php";

        file_put_contents($filePath, $resourceTemplate);

        $this->info("$filePath generated");
    }

    protected function generateFilter($name)
    {
        $filterTemplate = $this->getTemplate($name, 'Filter');

        $folderPath = app_path('Filters/' . $this->getNamespace());

        $this->makeDirIfNotExist(app_path('Filters/' . $this->getNamespace()));

        $filePath = $folderPath . "/{$name}Filter.php";

        file_put_contents($filePath, $filterTemplate);

        $this->info("$filePath generated");
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

        $folderPath = app_path('Http/Requests/' . $this->getNamespace());

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/Store{$name}Request.php";

        file_put_contents($filePath, $requestTemplate);

        $this->info("$filePath generated");
    }

    protected function writeUpdateRequest($name)
    {
        $requestTemplate = $this->getTemplate($name, 'UpdateRequest');

        $folderPath = app_path('Http/Requests/' . $this->getNamespace());

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/Update{$name}Request.php";

        file_put_contents($filePath, $requestTemplate);

        $this->info("$filePath generated");
    }

    protected function writeIndexBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'IndexBlade');

        $folderPath = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/index.blade.php";

        file_put_contents($filePath, $bladeTemplate);

        $this->info("$filePath generated");
    }

    protected function writeCreateBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'CreateBlade');

        $folderPath = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/create.blade.php";

        file_put_contents($filePath, $bladeTemplate);

        $this->info("$filePath generated");
    }

    protected function writeEditBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'EditBlade');

        $folderPath = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/edit.blade.php";

        file_put_contents($filePath, $bladeTemplate);

        $this->info("$filePath generated");
    }

    protected function writeIndexComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'IndexComponentVue');

        $folderPath = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/Index{$name}Component.vue";

        file_put_contents($filePath, $vueTemplate);

        $this->info("$filePath generated");
    }

    protected function writeCreateComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'CreateComponentVue');

        $folderPath = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/Create{$name}Component.vue";

        file_put_contents($filePath, $vueTemplate);

        $this->info("$filePath generated");
    }

    protected function writeEditComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'EditComponentVue');

        $folderPath = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/Edit{$name}Component.vue";

        file_put_contents($filePath, $vueTemplate);

        $this->info("$filePath generated");
    }

    protected function writeRoute($name)
    {
        $routes = $this->getRoutes($name);

        $filePath = base_path('routes/' . $this->getRouteFile());

        File::append($filePath, $routes);

        $this->info("$filePath updated");
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

    protected function makeDirIfNotExist($path)
    {
        if(!file_exists($path))
            mkdir($path, 0777, true);
    }

    protected function getRoutes($name)
    {
        $routes = '
        Route::resource(\'' . str_plural(strtolower($name)) . "', '{$name}Controller');";

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
