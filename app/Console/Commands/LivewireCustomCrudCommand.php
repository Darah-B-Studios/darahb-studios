<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class LivewireCustomCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:livewire:crud {class_name? : The name of the class.},
    {model_name? : The name of the model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CRUD functionality for livewire model';

    /**
     * Custom variables
     * */
    protected $class_name;
    protected $model_name;
    protected $file;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->file = new Filesystem();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Gather the param values
        $this->getParams();

        // Generate livewire class file
        $this->generateLivewireCrudClassFile();

        // Generate the view file
        $this->generateLivewireCrudViewFile();
    }

    /**
     * Get the values from the parameters passed
     * In the command.
     *
     * @return void
     */
    protected function getParams()
    {
        $this->class_name = $this->argument('class_name');
        $this->model_name = $this->argument('model_name');

        // Ask class name if no class name provided
        if (!$this->class_name) {
            $this->class_name = $this->ask('Enter class name: ');
        }

        // Ask model name if not provided
        if (!$this->model_name) {
            $this->model_name = $this->ask('Enter model name: ');
        }

        /* convert params to match studly case */
        $this->class_name = Str::studly($this->class_name);
        $this->model_name = Str::studly($this->model_name);
    }

    /**
     * Generate CRUD files for the livewire component
     *
     * @return void
     */
    protected function generateLivewireCrudClassFile()
    {
        // set the origin and destination of the livewire class file
        $file_origin = base_path('/stubs/custom.livewire.crud.stub');
        $file_destination = base_path('/app/Http/Livewire/' . $this->class_name . '.php');

        if ($this->file->exists($file_destination)) {
            $this->info('This class file already exists: ' . $this->class_name . '.php');
            return false;
        }
        // get the content of the file
        $file_original_string = $this->file->get($file_origin);

        // replaced file content
        $replaced_file_content = Str::replaceArray('{{}}', [
            $this->model_name, // use App\Models\{{}};
            $this->class_name, // class {{}} extends Component
            $this->model_name, // showDeleteModal fn
            $this->model_name, // index fn
            $this->model_name, // create fn
            $this->model_name, // edit fn
            $this->model_name, // update fn
            $this->model_name, // delete fn
            $this->model_name, // loadData fn
            Str::kebab($this->class_name), // render fn: view('livewire.{{}}'...
            Str::snake($this->class_name), // render fn: parse params
        ], $file_original_string);

        // put file content in destination directory
        $this->file->put($file_destination, $replaced_file_content);

        $this->info('Livewire class file created: ' . $file_destination);
    }

    /**
     * Generate the view file to manage CRUD operations
     * for this model and class.
     *
     * @return void
     */
    public function generateLivewireCrudViewFile()
    {

        // set the origin and destination of the livewire class file
        $file_origin = base_path('/stubs/custom.livewire.crud.view.stub');
        $file_destination = base_path('/resources/views/livewire/' . Str::kebab($this->class_name) . '.blade.php');

        if ($this->file->exists($file_destination)) {
            $this->info('This view file already exists: ' . Str::kebab($this->class_name) . '.php');
            return false;
        }

        // get the content of the file
        $file_original_string = $this->file->get($file_origin);

        $replaced_file_content = Str::replaceArray('{{}}', [
            Str::snake($this->model_name), // plural parameter
            Str::snake($this->model_name), // singular parameter
            Str::snake($this->model_name), // edit param
            Str::snake($this->model_name), // delete param
            Str::snake($this->class_name), // pagination links
        ], $file_original_string);

        // copy file content in destination directory
        // $this->file->copy($replaced_file_content, $file_destination);
        $this->file->put($file_destination, $replaced_file_content);

        $this->info('Livewire view file created: ' . $file_destination);
    }
}