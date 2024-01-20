<?php

namespace App\Jobs;

use App\Models\WatchHistory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class WatchHistoryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $data;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->onQueue('watch_history');
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $response = Http::get('http://ip-api.com/json/' . $this->data['ip']);

        if ($response->successful()) {
            $data = $response->json();

            if ($data['status'] != 'fail') {
                WatchHistory::create([
                    'student_id' => isset($this->data['student_id']) ? $this->data['student_id'] : null,
                    'parent_id' => isset($this->data['parent_id']) ? $this->data['parent_id'] : null,
                    'lecture_id' => isset($this->data['lecture_id']) ? $this->data['lecture_id'] : null,
                    'lecture_video_id' => isset($this->data['lecture_video_id']) ? $this->data['lecture_video_id'] : null,
                    'question_id' => isset($this->data['question_id']) ? $this->data['question_id'] : null,
                    'question_video_id' => isset($this->data['question_video_id']) ? $this->data['question_video_id'] : null,
                    'type' => $this->data['type'],
                    'ip' => $this->data['ip'],
                    'country' => $data['country']
                ]);
            }
        }
    }
}
