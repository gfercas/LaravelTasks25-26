<?php

namespace App\Livewire;

use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TasksComponent extends Component
{
    public $tasks = [];
    public $modal = false;
    public $title;
    public $description;

    public function mount()
    {
        $this->getTasks();
    }

    public function getTasks()
    {
        $user = Auth::User();
        $this->tasks = $user->tasks;
    }

    public function openCreateModal()
    {
        $this->modal = true;
    }

    public function closeCreateModal()
    {
        $this->modal = false;
    }

    public function createTask()
    {
        Task::create([
            'title' => $this->title,
            'description' => $this->description,
            'user_id' => Auth::user()->id
        ]);
        $this->closeCreateModal();
    }

    public function render()
    {
        return view('livewire.tasks-component');
    }
}
