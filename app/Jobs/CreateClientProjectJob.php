<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use App\Models\Project_assignment;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Notifications\ProjectAssignedNotification;

class CreateClientProjectJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $attachements = [];
    protected $descriptions;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project, $descriptions, $attachements = [])
    {
        $this->project = $project;
        $this->attachements = $attachements;
        $this->descriptions = $descriptions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = Project_assignment::getAssignTo('commercial');

        // $this->project->members()->attach([$user->id]);
        $this->project->members()->attach([12]);

        $this->project->descriptions()->createMany($this->descriptions);
        if ($this->attachements) {
            $this->project->files()->createMany($this->attachements);
        }
        $user->notify(new ProjectAssignedNotification($this->project));
    }
}
