<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class Users extends Component
{
    use WithPagination;

    public $model;
    public $name;
    public $email;
    public $role;
    public $show_create_modal = false;
    public $show_delete_modal = false;

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required',
            'role' => 'required'
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
    public function showDeleteModal(User $model)
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
        return User::paginate(5);
    }

    /**
     * Create new navigation_menu
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        User::create($this->modelData());
        $this->show_create_modal = false;
        $this->reset();
    }

    /**
     * Edit provided model
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function edit(User $model)
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
    public function update(User $model)
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
    public function delete(User $model)
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
    public function loadData(User $model)
    {
        $this->name = $model->name;
        $this->email = $model->email;
        $this->role = $model->role;
    }

    /**
     * Set the model data, populate all model fields
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];
    }

    /**
     * Main renderer function to load livewire component
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.users', [
            'users' => $this->index(), // replace with camelcase model name
        ]);
    }
}