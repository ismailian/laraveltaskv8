<?php

namespace App\Http\Controllers;

use App\Jobs\PostCreated;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Website;

class PostController extends Controller
{
    
    /**
     * create a new post
     */
    public function create(Request $request)
    {

        /* validate post parameters */
        $valid = $request->validate([
            'website_id'  => 'required|numeric',
            'title'       => 'required|min:5',
            'description' => 'required|min:5',
        ]);

        /** check if website exists */
        $website = Website::find($valid['website_id']);
        if (!$website) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid website!',
            ]);
        }

        /** save resource */
        $post = new Post();
        $post = $post->create([
            'website_id'  => $valid['website_id'],
            'title'       => $valid['title'],
            'description' => $valid['description'],
        ]);

        if (!$post) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to create post.',
            ]);
        }

        /** add post to the queue to be sent to subscribers */
        dispatch(new PostCreated($post, $website));

        return response()->json([
            'status'  => true,
            'message' => 'Post was created successfully.',
        ]);
    }

}
