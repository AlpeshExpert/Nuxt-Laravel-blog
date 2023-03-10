<?php

namespace App\Http\Requests\Api;

use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'content' => 'required',
            'feature_image' => 'required'
        ];
    }

    protected function prepareForValidation(){
        // $path = $this->file('featured_image')->store('posts');
        // $path = Storage::putFile('posts', $this->file('featured_image'),'public');
        $file_name = time().$this->featured_image->getClientOriginalName();
        $this->featured_image->move(public_path('posts'),$file_name);
        $path = 'posts/'.$file_name;
        $this->merge(['feature_image'=>$path]);
    }
}
