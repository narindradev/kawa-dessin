<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\ProjectAssignedNotification;

class memberAssignedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $created_by;
    protected $ids;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project ,$ids = [] ,User $created_by)
    {
        $this->project = $project;
        $this->ids = $ids;
        $this->created_by = $created_by;
    }

    /**
     * Execute the job.
     *Auth::user()
     * @return void
     */
    public function handle()
    {
        $users = User::findMany($this->ids);
        \Notification::send($users, (new ProjectAssignedNotification($this->project, $this->created_by)));
    }
}