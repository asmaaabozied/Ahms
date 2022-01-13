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
use Modules\News\Entities\NewsCategory;

class NewsListRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $new_category = NewsCategory::find($this->news_category_id);

        if ($new_category->type == "video") {
            $rules = [
                "video_link" => "required|url",
                "main_image" => "required|image|file",
                "images_slider.*" => "sometimes|image|file"
            ];
            $ignore_id = !empty ($this->route()->parameters()['news_subcategory']) ? $this->route()->parameters()['news_subcategory']->id : "";
            foreach (config('translatable.locales') as $locale) {

                $rules += [$locale . '.title' => ['required', Rule::unique('news_subcategory_translations', 'title')->ignore($ignore_id, 'news_sub_category_id')]];
                $rules += [$locale . '.content' => ['required']];

            }
        } else {
            $rules = [
                "main_image" => "required|image|file",
            ];
            $ignore_id = !empty ($this->route()->parameters()['news_subcategory']) ? $this->route()->parameters()['news_subcategory']->id : "";
            foreach (config('translatable.locales') as $locale) {

                $rules += [$locale . '.title' => ['required', Rule::unique('news_subcategory_translations', 'title')->ignore($ignore_id, 'news_sub_category_id')]];
                $rules += [$locale . '.content' => ['required']];

            }
        }

        return $rules;

    }

}
