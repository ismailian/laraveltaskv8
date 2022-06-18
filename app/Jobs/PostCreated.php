<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Support\Facades\Mail;
use App\Mail\PostNotification;

class PostCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Post $post
     */
    public $post;

    /**
     * @var Website $website
     */
    public $website;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Post $post, Website $website)
    {
        $this->post = $post;
        $this->website = $website;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscribers = $this->website->subscribers()->get(['id', 'fullname', 'email']);

        foreach ($subscribers as $subscriber) {

            /** send email notification */
            Mail::to($subscriber->email)->send(new PostNotification($this->post));

        }

    }
}
