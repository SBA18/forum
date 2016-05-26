<?php

namespace Forum\Http\Controllers\Report;

use Forum\Models\Post;
use Forum\Models\Topic;
use Forum\Http\Requests;
use Illuminate\Http\Request;
use Forum\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Lists all reported topics and posts.
     * @return \Illuminate\Http\Response
     */
    public function all(Post $post, Topic $topic)
    {
        $topics = $topic->get();
        $posts = $post->with('reports.user')->get();

        return view('moderation.report.reports', [
            'topics' => $topics,
            'posts' => $posts,
        ]);
    }
}
