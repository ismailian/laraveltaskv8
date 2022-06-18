<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    
    /**
     * subscribe to a website
     */
    public function subscribe(Request $request)
    {

        /** validate incoming data */
        $valid = $request->validate([
            'website_id' => 'required|numeric',
            'fullname'   => 'required|min:10',
            'email'      => 'required|email',
        ]);

        /** find website */
        $websiteId = $valid['website_id'];
        $website = Website::find($websiteId);
        if (!$website) {
            return response()->json([
                'status'  => false,
                'message' => 'Invalid website!',
            ]);
        }

        /** check if not subscribed already */
        $isSubscribed = Subscriber::where(['website_id' => $website->id, 'email' => $valid['email']])->first();
        if ($isSubscribed) {
            return response()->json([
                'status'  => false,
                'message' => 'You are already subscribed to this website',
            ]);
        }

        /** save resource */
        $subscriber = new Subscriber();
        $subscriber = $subscriber->create([
            'website_id' => $valid['website_id'],
            'fullname'   => $valid['fullname'],
            'email'      => $valid['email'],
        ]);

        if (!$subscriber) {
            return response()->json([
                'status'  => false,
                'message' => 'Failed to subscribe to this website',
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'You have successfully subscribed to: ' . $website->name,
        ]);
    }

}
