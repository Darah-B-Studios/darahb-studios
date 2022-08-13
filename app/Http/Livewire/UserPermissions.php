<?php

namespace App\Http\Livewire;

use App\Models\UserPermission;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Validation\Rule;

class UserPermissions extends Component
{
    use WithPagination;

    public $model;
    public $role;
    public $route_name;
    public $show_create_modal = false;
    public $show_delete_modal = false;

    public function rules()
    {
        return [
            'role' => 'required',
            'route_name' => 'required'
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
    public function showDeleteModal(UserPermission $model)
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
        return UserPermission::paginate(5);
    }

    /**
     * Create new navigation_menu
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        UserPermission::create($this->modelData());
        $this->show_create_modal = false;
        $this->reset();
    }

    /**
     * Edit provided model
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function edit(UserPermission $model)
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
    public function update(UserPermission $model)
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
    public function delete(UserPermission $model)
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
    public function loadData(UserPermission $model)
    {
        $this->role = $model->role;
        $this->route_name = $model->route_name;
    }

    /**
     * Set the model data, populate all model fields
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'role' => $this->role,
            'route_name' => $this->route_name,
        ];
    }

    /**
     * Main renderer function to load livewire component
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.user-permissions', [
            'user_permissions' => $this->index(), // replace with camelcase model name
        ]);
    }
}