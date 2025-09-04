<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageSearchController extends Controller
{
    public function search(Request $request) {
            $validate = Validator::make($request->all(), [
                'query' => 'required|string|min:2|max:100'
            ])
    }
}
