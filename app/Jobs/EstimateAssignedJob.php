<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\User;
use App\Notifications\EstimateAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EstimateAssignedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

    protected $project;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // $user= $this->project->client->user;
        $user = User::find(51);
        $user->notify(new EstimateAssignedNotification($this->project));
    }
}
