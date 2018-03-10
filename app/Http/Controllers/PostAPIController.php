<?php

namespace App\Http\Controllers;

use App\Post;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostAPIController extends APIBaseController
{

    public function  index()
    {
        $posts = Post::all();
        return $this->sendResponse($posts->toArray(),'Posts Retrived Successfully');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'name'=>'required',
            'descriptions'=>'required',
        ]);
        if($validator->fails())
        {
            return $this->sendError('Validator Error',$validator->errors());
        }

        $post = Post::create($input);
        return $this->sendResponse($post->toArray(),'Post Created Succesfully');
    }

    public  function show($id)
    {
        $post = Post::find($id);

        if(is_null($post))
        {
            return $this->sendError('Post Not Found');
        }
        return $this->sendResponse($post->toArray(),'Post retrived Sucessfully');
    }

    public function update(Request $request,$id)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'descriptions' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validator Error', $validator->errors());
        }

        $post = Post::find($id);
        if (is_null($post)) {
            return $this->sendError('Post Not Found to Update');
        }

        $post->name = $input['name'];
        $post->descriptions = $input['descriptions'];
        $post->save();

        return $this->sendResponse($post->toArray(), 'Post Updated ');


    }

    public  function destroy($id)
    {

        $post = Post::find($id);
        if(is_null($post))
        {
            return $this->sendError("Post Not Found");
        }
        $post->delete();

        return $this->sendResponse($post->toArray(),'Post Deleted');

    }
}
