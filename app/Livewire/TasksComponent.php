<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TasksComponent extends Component
{
    public $tasks = [];

    public function mount()
    {
        $this->getTasks();
    }

    public function getTasks()
    {
        $user = Auth::User();
        $this->tasks = $user->tasks;
    }

    public function render()
    {
        return view('livewire.tasks-component');
    }
}
