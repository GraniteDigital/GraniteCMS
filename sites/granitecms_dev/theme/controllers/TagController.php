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

        $hook = config('hooks');
        $hook->addHook('after_CRUD_POST_processing', 10, [$this, 'processTagInput']);
        $hook->addHook('during_CRUD_field_display', 10, [$this, 'renderTagInput']);
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

    public function processTagInput($request, $fields, $set_values, $id)
    {
        foreach ($fields as $field) {
            if ($field['type'] == 'custom_taginput') {
                $tags = $request[$field['name']];
                $this->batchStore($tags, $id);
            }
        }
    }

    public function renderTagInput($field, $value)
    {
        $siteID = request()->route('id');

        $tags = Tag::where('postings', 'LIKE', '%"' . $siteID . '"%')
            ->orWhere('postings', 'LIKE', '%"' . $siteID . '"' . ',%')
            ->orWhere('postings', 'LIKE', '%,' . '"' . $siteID . '"' . ',%')
            ->orWhere('postings', 'LIKE', '%,' . '"' . $siteID . '"%')
            ->pluck('tag');

        $value = implode(',', $tags->toArray());

        if ($field['type'] == 'custom_taginput') {
            return view('components.text')->with(['field' => $field, 'value' => $value]);
        }
    }

    public function store($tag, $siteID)
    {
        $tag = trim($tag);
        $tag = $this->stemmer->stem($tag);

        $tagObj = Tag::where('tag', $tag)->first();
        if ($tagObj != null) {
            // Tag exists, update instead of create
            $postings = json_decode($tagObj->postings);

            if (!in_array($siteID, $postings)) {
                // Postings are a set, each ID must be unique
                $postings[] = $siteID;
                $tagObj->postings = json_encode($postings);
                $tagObj->save();
            }
        } else {
            $tagObj = Tag::create(['tag' => $tag, 'postings' => json_encode([$siteID])]);
        }
        return apiResponse(SUCCESS, $tagObj);
    }

    public function batchStore($tags, $siteID)
    {
        if (!is_array($tags)) {
            // if it's a comma-separated list, convert to array
            $tags = explode(',', $tags);
        }

        foreach ($tags as $tag) {
            $this->store($tag, $siteID);
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
            $tags = explode(' ', $tags);
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
            $postings_lists = array_merge($postings_lists, json_decode($tag->postings));
        }

        $frequencies = array_count_values($postings_lists);
        asort($frequencies);

        return $frequencies;
    }
}
