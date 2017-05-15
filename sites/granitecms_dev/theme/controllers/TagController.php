<?php

namespace Sites\granitecms_dev\theme\controllers;

use App\Http\Controllers\Controller;
use Sites\granitecms_dev\theme\Query;
use Sites\granitecms_dev\theme\Tag;
use Wamania\Snowball\English;

class TagController extends Controller
{

    public function __construct()
    {
        $this->stemmer = new English();
    }

    public function index()
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function show($tag)
    {
        $tag = $this->stemmer->stem($tag);

        $tag = Tag::where('tag', $tag)->first();
        if ($tag != null) {
            return apiResponse(SUCCESS, $tag);
        }

        return apiResponse(NO_CONTENT);
    }

    public function store($tag, $siteID)
    {
        $tag = $this->stemmer->stem($tag);

        $tag = Tag::where('tag', $tag)->first();
        if ($tag != null) {
            // Tag exists, update instead of create
            $postings = json_decode($tag->postings);

            if (!in_array($siteID, $postings)) {
                // Postings are a set, each ID must be unique
                $postings[] = $siteID;
                $tag->postings = json_encode($postings);
                $tag->save();
            }
        } else {
            $tag = Tag::create(['tag' => $tag, 'postings' => [$siteID]]);
        }
        return apiResponse(SUCCESS, $tag);
    }

    public function batchStore($tags, $siteID)
    {
        if (!is_array($tags)) {
            // if it's a comma-separated list, convert to array
            $tags = explode(',', $tags);
        }

        foreach ($tags as $tag) {
            yield $this->store($tag, $siteID);
        }
    }

    public function get($tags)
    {
        if (!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        $stemmed_tags = [];
        foreach ($tags as $tag) {
            $stemmed_tags[] = $this->stemmer->stem($tag);
        }

        $tags = Tag::getFromTags($stemmed_tags)->get();

        return apiResponse(SUCCESS, $tags);
    }

    public function search($tags)
    {

        if (!is_array($tags)) {
            $tags = explode(',', $tags);
        }

        $stemmed_tags = [];
        foreach ($tags as $tag) {
            $stemmed_tags[] = $this->stemmer->stem($tag);
        }

        $search_tags = Tag::getFromTags($stemmed_tags)->get();

        $results = $this->mergePostings($search_tags);
        Query::create(['query' => implode(',', $tags), 'results' => json_encode($results)]);

        return apiResponse(SUCCESS, $results);
    }

    public function mergePostings($tags)
    {
        $postings_lists = [];

        foreach ($tags as $tag) {
            $postings_lists = array_merge($postings_lists, $tag->postings);
        }

        $frequencies = array_count_values($postings_lists);
        asort($frequencies);

        return $frequencies;
    }
}
