<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Notifications\ProjectUpdatedNotification;

class SendUpdatedProjectNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $project;
    protected $created_by;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Project $project , User $created_by )
    {
        $this->project = $project;
        $this->created_by = $created_by;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        \Notification::send(get_cache_member( $this->project),new ProjectUpdatedNotification($this->project, $this->created_by));
    }
}
