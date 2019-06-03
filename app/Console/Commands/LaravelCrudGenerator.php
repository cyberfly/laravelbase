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
     * The default breadcrumb route file
     *
     * @var string
     */
    protected $breadcrumb_route_file = 'breadcrumbs.php';

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
        $this->generatePolicy($name);
        $this->generateBlade($name);
        $this->generateVueComponent($name);

        $this->writeRoute($name);
        $this->writeBreadcrumb($name);
        $this->writeAppJs($name);
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

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/{$name}Resource.php";

        file_put_contents($filePath, $resourceTemplate);

        $this->info("$filePath generated");
    }

    protected function generateFilter($name)
    {
        $filterTemplate = $this->getTemplate($name, 'Filter');

        $folderPath = app_path('Filters/' . $this->getNamespace());

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/{$name}Filter.php";

        file_put_contents($filePath, $filterTemplate);

        $this->info("$filePath generated");
    }

    protected function generatePolicy($name)
    {
        $policyTemplate = $this->getTemplate($name, 'Policy');

        $folderPath = app_path('Policies/' . $this->getNamespace());

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/{$name}Policy.php";

        file_put_contents($filePath, $policyTemplate);

        $this->info("$filePath generated");
    }

    protected function generateBlade($name)
    {
        $this->writeIndexBlade($name);
        $this->writeCreateBlade($name);
        $this->writeEditBlade($name);
        $this->writeShowBlade($name);
    }

    protected function generateVueComponent($name)
    {
        $this->writeIndexComponent($name);
        $this->writeCreateComponent($name);
        $this->writeEditComponent($name);
        $this->writeShowComponent($name);
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

    protected function writeShowBlade($name)
    {
        $bladeTemplate = $this->getTemplate($name, 'ShowBlade');

        $folderPath = resource_path('views/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/show.blade.php";

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

    protected function writeShowComponent($name)
    {
        $vueTemplate = $this->getTemplate($name, 'ShowComponentVue');

        $folderPath = resource_path('components/' . $this->getViewNamespace() . '/' . strtolower(str_plural($name)));

        $this->makeDirIfNotExist($folderPath);

        $filePath = $folderPath . "/Show{$name}Component.vue";

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

    protected function writeBreadcrumb($name)
    {
        $breadcrumbs = $this->getBreadcrumbs($name);

        $filePath = base_path('routes/' . $this->getBreadcrumbFile());

        File::append($filePath, $breadcrumbs);

        $this->info("$filePath updated");
    }

    /**
     * Register generated Vue components
     * @param $name
     */
    protected function writeAppJs($name)
    {
        $componentRegisters = $this->getComponentRegisters($name);

        $filePath = resource_path('assets/js/laravel/app.js');

        File::append($filePath, $componentRegisters);

        $this->info("$filePath updated");
    }

    protected function getTemplate($name, $stub)
    {
        $template = str_replace(
            [
                '{{modelName}}',
                '{{modelNameUpperCase}}',
                '{{modelNamePlural}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{routeNamespace}}',
                '{{viewNamespace}}',
                '{{namespace}}',
            ],
            [
                $name,
                strtoupper($name),
                str_plural($name),
                strtolower(str_plural($name)),
                strtolower($name),
                $this->getRouteNamespace(),
                $this->getViewNamespace(),
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
            // generated ' . str_plural(strtolower($name)) . ' routes

            Route::get(\'' . str_plural(strtolower($name)) . '\', \'' . $name . 'Controller@index\')->name(\'' . str_plural(strtolower($name)) . '.index\');
            Route::get(\'' . str_plural(strtolower($name)) . '/indexdata\', \'' . $name . 'Controller@indexData\')->name(\'' . str_plural(strtolower($name)) . '.indexdata\');
            Route::get(\'' . str_plural(strtolower($name)) . '/create\', \'' . $name . 'Controller@create\')->name(\'' . str_plural(strtolower($name)) . '.create\');
            Route::get(\'' . str_plural(strtolower($name)) . '/{' . strtolower($name) . '_id}\', \'' . $name . 'Controller@show\')->name(\'' . str_plural(strtolower($name)) . '.show\');
            Route::get(\'' . str_plural(strtolower($name)) . '/{' . strtolower($name) . '_id}/edit\', \'' . $name . 'Controller@edit\')->name(\'' . str_plural(strtolower($name)) . '.edit\');

            Route::post(\'' . str_plural(strtolower($name)) . '\', \'' . $name . 'Controller@store\')->name(\'' . str_plural(strtolower($name)) . '.store\');

            Route::put(\'' . str_plural(strtolower($name)) . '/{' . strtolower($name) . '_id}\', \'' . $name . 'Controller@update\')->name(\'' . str_plural(strtolower($name)) . '.update\');

            Route::delete(\'' . str_plural(strtolower($name)) . '/{' . strtolower($name) . '_id}\', \'' . $name . 'Controller@destroy\')->name(\'' . str_plural(strtolower($name)) . '.destroy\');
        ';

        return $routes;
    }

    protected function getBreadcrumbs($name)
    {
        $breadcrumbs= '
// generated ' . str_plural(strtolower($name)) . ' breadcrumbs

Breadcrumbs::for(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.index\', function ($trail) {
    $trail->parent(\'' . $this->getRouteNamespace() . '.dashboard\');
    $trail->push(\'' . $name . ' List\', route(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.index\'));
});

Breadcrumbs::for(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.create\', function ($trail) {
    $trail->parent(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.index\');
    $trail->push(\'Create ' . $name . '\', route(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.create\'));
});

Breadcrumbs::for(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.edit\', function ($trail, $location_id) {
    $trail->parent(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.index\');
    $trail->push(\'Edit ' . $name . '\', route(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.edit\', $location_id));
});

Breadcrumbs::for(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.show\', function ($trail, $location_id) {
    $trail->parent(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.index\');
    $trail->push(\'Show ' . $name . '\', route(\'' . $this->getRouteNamespace() . '.' . str_plural(strtolower($name)) . '.show\', $location_id));
});
        ';

        return $breadcrumbs;
    }

    protected function getComponentRegisters($name)
    {
        $componentRegisters = '
// generated ' . str_plural(strtolower($name)) . ' components

Vue.component(\'index-' . strtolower($name) . '-component\', require(\'../../../components/' . $this->getViewNamespace() . '/' . str_plural(strtolower($name)) . '/Index' . $name . 'Component.vue\'));
Vue.component(\'create-' . strtolower($name) . '-component\', require(\'../../../components/' . $this->getViewNamespace() . '/' . str_plural(strtolower($name)) . '/Create' . $name . 'Component.vue\'));
Vue.component(\'edit-' . strtolower($name) . '-component\', require(\'../../../components/' . $this->getViewNamespace() . '/' . str_plural(strtolower($name)) . '/Edit' . $name . 'Component.vue\'));
Vue.component(\'show-' . strtolower($name) . '-component\', require(\'../../../components/' . $this->getViewNamespace() . '/' . str_plural(strtolower($name)) . '/Show' . $name . 'Component.vue\'));
        ';

        return $componentRegisters;
    }

    protected function getNamespace()
    {
        return $this->namespace;
    }

    protected function getRouteFile()
    {
        return $this->route_file;
    }

    protected function getBreadcrumbFile()
    {
        return $this->breadcrumb_route_file;
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
