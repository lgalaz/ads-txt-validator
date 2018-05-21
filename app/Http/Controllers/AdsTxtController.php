<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Jobs\ParseAdsTxt;
use PHPUnit\Runner\Exception;
use App\AdsTxt;

class AdsTxtController extends Controller
{
    /**
     * Store a new ads txt instance to the database.
     *
     * @param  array  $data
     * @return \App\AdsTxt
     */
    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ads-file' => 'required|mimetypes:text/plain'
        ]);

        if ($validator->fails() || !$request->file('ads-file')->isValid()) {
            return Redirect::route('ads-file.create')->withErrors([
                'ads-file' => 'The uploaded ads.txt file as not found or is invalid.'
            ]);
        }

        $errors = [];
        $content = '';

        try {
            $content = File::get($request->file('ads-file')->getRealPath());

            ParseAdsTxt::dispatch($content);
        } catch (Exception $e) {
            $errors = ['ads-file' => $e->getMessage()];
        }

        $filename = str_random(30) . '.txt';

        $request->file('ads-file')->storeAs('uploads', $filename);

        AdsTxt::create([
            'contents' => $content,
            'name' => $filename,
            'status' => (count($errors) > 0) ? 'valid' : 'invalid',
            'url' => asset('uploads/' . $filename)
        ]);

        if ($errors) {
            return Redirect::route('ads-file.create')
                ->withErrors($errors)
                ->with(['name' => $filename]);
        }

        return Redirect::route('ads-file.create')->with([
            'success' => 'The ads file was created correctly.',
            'name' => $filename
        ]);
    }
}
