<?php

namespace App\Http\Livewire;

use App\Models\NavigationMenu;
use App\Models\Page;
use Illuminate\Validation\Rule;
use Livewire\Component;

class NavigationMenus extends Component
{
    public $sequence;
    public $type;
    public $label;
    public $slug;
    public $navigation_menu;
    public $show_create_modal = false;
    public $show_delete_modal = false;

    public function rules()
    {
        return [
            'sequence' => 'required',
            'type' => 'required',
            'label' => 'required',
            'slug' => ['required', Rule::unique('navigation_menus', 'slug')->ignore($this->navigation_menu)]
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
     * @param  NavigationMenu $navigation_menu
     * @return void
     */
    public function showDeleteModal(NavigationMenu $navigation_menu)
    {
        $this->navigation_menu = $navigation_menu;
        $this->show_delete_modal = true;
    }


    /**
     * Base function to return data
     *
     * @return void
     */
    public function index()
    {
        return NavigationMenu::paginate(5);
    }

    /**
     * Create new navigation_menu
     *
     * @return void
     */
    public function create()
    {
        $this->validate();
        NavigationMenu::create($this->modelData());
        $this->show_create_modal = false;
        $this->reset();
    }

    /**
     * Edit provided model
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function edit(NavigationMenu $navigation_menu)
    {
        $this->clearValidation();
        $this->show_create_modal = true;
        $this->loadData($navigation_menu);
        $this->navigation_menu = $navigation_menu;
    }

    /**
     * Update provided model
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function update(NavigationMenu $navigation_menu)
    {
        $this->navigation_menu = $navigation_menu;
        $this->show_create_modal = true;
        $navigation_menu->update($this->modelData());
        $this->show_create_modal = false;
    }

    /**
     * Delete provided model
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function delete(NavigationMenu $navigation_menu)
    {
        $this->navigation_menu = $navigation_menu;
        $navigation_menu->delete();
        $this->show_delete_modal = false;
        $this->reset();
    }

    /**
     * Load model data when needed
     *
     * @param  mixed $navigation_menu
     * @return void
     */
    public function loadData(NavigationMenu $navigation_menu)
    {
        $this->sequence = $navigation_menu->sequence;
        $this->slug = $navigation_menu->slug;
        $this->type = $navigation_menu->type;
        $this->label = $navigation_menu->label;
    }

    /**
     * Set the model data, populate all model fields
     *
     * @return void
     */
    public function modelData()
    {
        return [
            'sequence' => $this->sequence,
            'slug' => $this->slug,
            'label' => $this->label,
            'type' => $this->type,
        ];
    }

    /**
     * Main renderer function to load livewire component
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.navigation-menus', [
            'navigation_menus' => $this->index(),
            'pages' => Page::all()
        ]);
    }
}