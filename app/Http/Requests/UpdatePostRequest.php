<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
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
      // 'title' => ['required', 'string', 'unique:posts,id,' . $this->post->id],

      'title' => ['required', 'string', Rule::unique('posts')->ignore($this->post->id)],
      'cover_image' => ['nullable', 'image', 'max:512'],
      'content' => ['required', 'string'],
      'category_id' => ['nullable', 'exists:categories,id'],
      'tags' => ['nullable', 'exists:tags,id'],
    ];
  }

  public function messages()
  {
    return [
      'title.required' => 'Il titolo è obbligatorio',
      'title.string' => 'Il titolo deve essere una stringa',
      'title.unique' => 'Esiste già un post con questo titolo',

      'cover_image.image' => 'Il file caricato deve essere un\'immagine',
      'cover_image.max' => 'Il file caricato deve avere una dimensione inferiore a 512KB',

      'content.required' => 'Il contenuto è obbligatorio',
      'content.string' => 'Il contenuto deve essere una stringa',

      'category_id.exists' => 'La categoria inserita non è valida',

      'tags.exists' => 'I tag inseriti non sono validi',
    ];
  }
}