<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ScheduledPost;
use App\Models\Announcement;
use App\Models\AuditLog;

class PublishScheduledPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:publish-due';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publishes all scheduled posts that are due for release';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting scheduled posts publishing...');

        $due = ScheduledPost::where('status', 'scheduled')
            ->where('publish_at', '<=', now())
            ->orderBy('publish_at', 'asc')
            ->get();

        if ($due->isEmpty()) {
            $this->info('No posts due for publishing.');
            return Command::SUCCESS;
        }

        $count = 0;
        foreach ($due as $post) {
            Announcement::create([
                'title' => $post->title,
                'content' => $post->content,
                'audience' => $post->audience ?: 'all',
                'created_by_user_id' => $post->created_by_user_id,
            ]);

            $post->update([
                'status' => 'published',
                'published_at' => now(),
            ]);

            // Add an audit log entry
            try {
                AuditLog::create([
                    'action_name' => 'scheduled_post_published',
                    'target_type' => 'announcements',
                    'target_id' => (string)$post->id,
                    'details_json' => json_encode(['title' => $post->title])
                ]);
            } catch (\Throwable $e) {}

            $count++;
            $this->info("Published post: {$post->title}");
        }

        $this->info("Successfully published {$count} posts.");
        return Command::SUCCESS;
    }
}
