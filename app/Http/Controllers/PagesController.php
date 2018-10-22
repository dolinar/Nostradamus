<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\BlogFeed;

class PagesController extends Controller
{
    public function index() 
    {
        $blogFeed = new BlogFeed("https://www.uefa.com/rssfeed/uefachampionsleague/rss.xml");
        $postsArray = $blogFeed->posts;
        $postsArray = array_slice($postsArray, 0, 5);
        return view('pages.index')->with("postsArray", $postsArray);
    }

    public function info() 
    {
        return view('pages.info');
    }

    public function table() 
    {
        return view('pages.table');
    }

    public function predictions() 
    {
        return view('pages.predictions');
    }

    public function results() 
    {
        return view('pages.results');
    }

    public function clDraw() 
    {
        return view('pages.cl_draw');
    }

    public function clResults() 
    {
        return view('pages.cl_results');
    }

    public function clStatistics() 
    {
        return view('pages.cl_statistics');
    }
}
