<?php

namespace App\Http\Livewire;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Events extends Component
{
    use WithPagination;

    public $model;

    public $name;
    public $description;
    public $venue;
    public $startTime;
    public $endTime;
    public $startDatae;
    public $endDate;

    public $show_create_modal = false;
    public $show_delete_modal = false;

    public function rules()
    {
        return [
            'slug' => ['required', Rule::unique('navigation_menus', 'slug')->ignore($this->model)]
        ];
    }

    /**
     * Show the form modal for the navigation_menu create functionality
     *
     * @return void
     */
    public function showCreateModal()
    {
        $this->reset();
        $this->show_create_modal = true;
        $this->clearValidation();
    }

    /**
     * Show the delete modal
     *
     * @param  mixed $model
     * @return void
     */
    public function showDeleteModal(Event $model)
    {
        $this->model = $model;
        $this->show_delete_modal = true;
    }

    /**
     * Base function to return data
     *
     * @return void
     */
    public function index()
    {
        return Event::paginate(5);
    }

    /**
     * Create new navigation_menu
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        Event::create($this->modelData());
        $this->show_create_modal = false;
        $this->reset();
    }

    /**
     * Edit provided model
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function edit(Event $model)
    {
        $this->clearValidation();
        $this->show_create_modal = true;
        $this->loadData($model);
        $this->model = $model;
    }

    /**
     * Update provided model
     *
     * @param  mixed $model
     * @return void
     */
    public function update(Event $model)
    {
        $this->model = $model;
        $this->show_create_modal = true;
        $model->update($this->modelData());
        $this->show_create_modal = false;
    }

    /**
     * Delete provided model
     *
     * @param  mixed $model
     * @return void
     */
    public function delete(Event $model)
    {
        $this->model = $model;
        $model->delete();
        $this->show_delete_modal = false;
        $this->reset();
    }

    /**
     * Load model data when needed
     *
     * @param  mixed $model
     * @return void
     */
    public function loadData(Event $model)
    {
        /* load model data here */

        $this->name = $model->name;
        $this->description = $model->description;
        $this->venue = $model->venue;
        $this->startTime = $model->startTime;
        $this->endTime = $model->endTime;
        $this->startDatae = $model->startDatae;
        $this->endDate = $model->endDate;
    }

    /**
     * Set the model data, populate all model fields
     *
     * @return void
     */
    public function modelData()
    {
        return [
            /**
             * Example:
             * 'name' => $this->name;
             */
            'name' => $this->name,
            'description' => $this->description,
            'venue' => $this->venue,
            'startTime' => $this->startTime,
            'endTime' => $this->endTime,
            'startDatae' => $this->startDatae,
            'endDate' => $this->endDate,
        ];
    }

    /**
     * Main renderer function to load livewire component
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.events', [
            'events' => $this->index(), // replace with camelcase model name
        ]);
    }
}