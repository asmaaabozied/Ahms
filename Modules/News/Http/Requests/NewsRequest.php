<?php
/**
 * Theqqa - Classified Ads Web Application
 * Copyright (c) BedigitCom. All Rights Reserved
 *
 * Website: http://www.
 *
  * Theqqa
 */

namespace Modules\News\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NewsRequest extends  FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

		$rules = [

            'type'=>'required'
        ];
        $ignore_id =!empty ( $this->route()->parameters()['news_category'])?$this->route()->parameters()['news_category']->id:"";
        foreach (config('translatable.locales') as $locale) {

            $rules += [$locale . '.title' => ['required', Rule::unique('news_category_translations', 'title')->ignore($ignore_id,'news_category_id')]];

        }
		return $rules;

    }

}
