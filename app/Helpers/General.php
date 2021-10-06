<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;
if (!function_exists('get_svg_icon')) {
    function get_svg_icon($path, $class = null, $svgClass = null)
    {
        if (strpos($path, 'media') === false) {
            $path = theme()->getMediaUrlPath() . $path;
        }

        $file_path = public_path($path);

        if (!file_exists($file_path)) {
            return '';
        }

        $svg_content = file_get_contents($file_path);

        if (empty($svg_content)) {
            return '';
        }

        $dom = new DOMDocument();
        $dom->loadXML($svg_content);

        // remove unwanted comments
        $xpath = new DOMXPath($dom);
        foreach ($xpath->query('//comment()') as $comment) {
            $comment->parentNode->removeChild($comment);
        }

        // add class to svg
        if (!empty($svgClass)) {
            foreach ($dom->getElementsByTagName('svg') as $element) {
                $element->setAttribute('class', $svgClass);
            }
        }

        // remove unwanted tags
        $title = $dom->getElementsByTagName('title');
        if ($title['length']) {
            $dom->documentElement->removeChild($title[0]);
        }
        $desc = $dom->getElementsByTagName('desc');
        if ($desc['length']) {
            $dom->documentElement->removeChild($desc[0]);
        }
        $defs = $dom->getElementsByTagName('defs');
        if ($defs['length']) {
            $dom->documentElement->removeChild($defs[0]);
        }

        // remove unwanted id attribute in g tag
        $g = $dom->getElementsByTagName('g');
        foreach ($g as $el) {
            $el->removeAttribute('id');
        }
        $mask = $dom->getElementsByTagName('mask');
        foreach ($mask as $el) {
            $el->removeAttribute('id');
        }
        $rect = $dom->getElementsByTagName('rect');
        foreach ($rect as $el) {
            $el->removeAttribute('id');
        }
        $xpath = $dom->getElementsByTagName('path');
        foreach ($xpath as $el) {
            $el->removeAttribute('id');
        }
        $circle = $dom->getElementsByTagName('circle');
        foreach ($circle as $el) {
            $el->removeAttribute('id');
        }
        $use = $dom->getElementsByTagName('use');
        foreach ($use as $el) {
            $el->removeAttribute('id');
        }
        $polygon = $dom->getElementsByTagName('polygon');
        foreach ($polygon as $el) {
            $el->removeAttribute('id');
        }
        $ellipse = $dom->getElementsByTagName('ellipse');
        foreach ($ellipse as $el) {
            $el->removeAttribute('id');
        }

        $string = $dom->saveXML($dom->documentElement);

        // remove empty lines
        $string = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $string);

        $cls = array('svg-icon');

        if (!empty($class)) {
            $cls = array_merge($cls, explode(' ', $class));
        }

        $asd = explode('/media/', $path);
        if (isset($asd[1])) {
            $path = 'assets/media/' . $asd[1];
        }

        $output = "<!--begin::Svg Icon | path: $path-->\n";
        $output .= '<span class="' . implode(' ', $cls) . '">' . $string . '</span>';
        $output .= "\n<!--end::Svg Icon-->";

        return $output;
    }
}

if (!function_exists('theme')) {
    /**
     * Get the instance of Theme class core
     *
     * @return \App\Core\Adapters\Theme|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function theme()
    {
        return app(\App\Core\Adapters\Theme::class);
    }
}

if (!function_exists('util')) {
    /**
     * Get the instance of Util class core
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     */
    function util()
    {
        return app(\App\Core\Adapters\Util::class);
    }
}

if (!function_exists('bootstrap')) {
    /**
     * Get the instance of Util class core
     *
     * @return \App\Core\Adapters\Util|\Illuminate\Contracts\Foundation\Application|mixed
     * @throws Throwable
     */
    function bootstrap()
    {
        $demo      = ucwords(theme()->getDemo());
        $bootstrap = "\App\Core\Bootstraps\Bootstrap$demo";

        if (!class_exists($bootstrap)) {
            abort(404, 'Demo has not been set or ' . $bootstrap . ' file is not found.');
        }

        return app($bootstrap);
    }
}

if (!function_exists('assetCustom')) {
    /**
     * Get the asset path of RTL if this is an RTL request
     *
     * @param $path
     * @param  null  $secure
     *
     * @return string
     */
    function assetCustom($path)
    {
        // Include rtl css file
        if (isRTL()) {
            return asset(theme()->getDemo() . '/' . dirname($path) . '/' . basename($path, '.css') . '.rtl.css');
        }

        // Include dark style css file
        if (theme()->isDarkModeEnabled() && theme()->getCurrentMode() !== 'default') {
            $darkPath = str_replace('.bundle', '.' . theme()->getCurrentMode() . '.bundle', $path);
            if (file_exists(public_path(theme()->getDemo() . '/' . $darkPath))) {
                return asset(theme()->getDemo() . '/' . $darkPath);
            }
        }

        // Include default css file
        return asset(theme()->getDemo() . '/' . $path);
    }
}

if (!function_exists('isRTL')) {
    /**
     * Check if the request has RTL param
     *
     * @return bool
     */
    function isRTL()
    {
        return (bool) request()->input('rtl');
    }
}




/** get the value of key in array 
 * @param array
 * @param string
 * @retrun mixte
 */
if (!function_exists('get_array_value')) {
    function get_array_value($array = [], $key = "", $default = null)
    {
        $value = null;
        if (array_key_exists($key, $array)) {
            $value = $array[$key];
            return $value;
        }
        if (!$value && $default) {
            return $default;
        }
        if (!$value && $default == []) {
            return $default;
        }
    }
}



/** 
 * Get a file type
 * @param string
 */
if (!function_exists('get_file_type')) {
    function get_file_type($extension = "")
    {
        $file_type = file_type();
        foreach ($file_type as $type => $extensions) {
            if (in_array(strtolower($extension), $extensions)) {
                return $type;
            }
        }
        return "file";
    }
}

/** 
 * All file type
 * @param string
 */
if (!function_exists('file_type')) {
    function file_type($type = "")
    {
        $types  = [
            "image" =>  ['.jpg', '.jpg', '.png', '.jpeg', '.jpeg', '.webp'],
            "video" =>  ['.wmv', '.avi', '.mov', '.3gp', '.ts', '.mp4', '.flv', ".mkv"],
            "audio" =>  ['.mp3', '.ogg', '.wav', '.mid', '.midi', ".wma", ".cda", ".wpl"],
            "doc"   =>  ['.txt', ".doc", ".php", ".xlx", ".pptx", ".pdf", ".odt", ".wpd"],
            "archive"   =>  ['.rar', ".zip", ".iso"],
        ];
        if ($type) {
            return  get_array_value($types, $type);
        }
        return $types;
    }
}
/** 
 *@param string
 * @param string
 */
if (!function_exists('app_check_secure')) {
    function app_check_secure($string = "", $data_encrypted = null, $from_ajax = false)
    {
        $is_secured = app_secure_encrypt($string) === $data_encrypted;
        if (!$is_secured) {
            if ($from_ajax) {
                die(json_encode(["success" => false, "message" => " Data not secured"]));
            } else {
                return abort(405);
            }
            return $is_secured;
        }
    }
}
/** 
 *@param string
 * @param string
 */
if (!function_exists('app_secure_encrypt')) {
    function app_secure_encrypt($string = "")
    {
        return md5(md5("app-encrypt-" . $string));
    }
}
/** 
 *@param string
 * @param string
 */
if (!function_exists('app_secure_input')) {
    function app_secure_input($name = "_data_secure", $value = "")
    {
        return "<input type ='hidden' name = '$name' value ='$value' />";
    }
}


/** 
 * Formater number ex. 1000 => 1k , 10000 => 1M
 * @param int
 * @param string $unit
 * @retrun string
 */
if (!function_exists('format_to_KMG')) {
    function format_to_KMG($number = 0, $unit = "")
    {
        $number_foramted = 0;

        if ($number >= 1000000000) {
            $number_foramted = round($number / 1000000000, 1) . 'G';
        } elseif ($number >= 1000000) {
            $number_foramted =  round($number / 1000000, 1) . 'M';
        } elseif ($number >= 1000) {
            $number_foramted =  round($number / 1000, 1) . 'K';
        } else {
            $number_foramted = $number;
        }
        if (strval($number) > 1 && $unit) {
            $unit = Str::of($unit)->plural();
        }
        return $number_foramted . " " . $unit;
    }
}

/** 
 * Get file uri
 * @param string
 * @param string
 * @retrun path
 */
if (!function_exists('get_file_uri')) {
    function get_file_uri($file = "", $path = "", $storage = "public")
    {
        if ($storage == "public") {
            return asset($path) . "/" . $file;
        }
    }
}


/**
 *  Return the image format ex : "100x50" => ["width" => 100, "height" => 50];
 *  @param string
 *  @retrun Array
 */
if (!function_exists('get_format_image')) {
    function get_format_image($format = "")
    {
        $specific_format = explode("x", $format);
        $width = intval($specific_format[0]);
        $height = intval($specific_format[1]);
        if ($width && $height) {
            return ["width" => $width, "height" => $height];
        }
    }
}

/** 
 * Uploader of  file 
 * @param Illuminate\Http\Request
 * @param string
 * @return array
 */
if (!function_exists('upload')) {
    function upload($file, $path = null, $public = true)
    {

        $extension = $file->extension();
        $size = $file->getSize();
        $file_type = get_file_type("." . $extension);
        $file_info = [];
        $file_info["success"] = false;
        if (!$file) {
            return $file_info;
        }
        $path =  $path ? $path : "uploads";
        $real_storage = ($public === "public") ? public_path($path) : storage_path("app/public/" . $path);
        $name =  $file_type . "-" . Str::uuid() . '.' . $extension;
        $file->move($real_storage, $name);
        $file_info["success"] = true;
        if ($name) {
            $file_info["url"]  = !$public ? $path . "/" . $name :  "storage/" . $path . "/" . $name;
            $file_info["src"]  = $real_storage . "\\" . $name;
            $file_info["type"] = $file_type;
            $file_info["size"] = $size;
            $file_info["name"] = $name;
            $file_info["extension"] = $extension;
            $file_info["originale_name"] = $file->getClientOriginalName();
            return $file_info;
        }
    }
}
/** 
 * Uploader of  file 
 * @param Illuminate\Http\Request
 * @param string
 * @return array
 */
if (!function_exists('move')) {
    function move($file, $path = null, $storage = "public")
    {
        return upload($file, $path, $storage);
    }
}


/**
 * prepare a anchor tag for any js request
 * 
 * @param string $title
 * @param array $attributes
 * @return html link of anchor tag
 */
if (!function_exists('js_anchor')) {

    function js_anchor($title = '', $attributes = [])
    {
        $title = (string) $title;
        $html_attributes = "";

        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $html_attributes .= ' ' . $key . '="' . $value . '"';
            }
        }

        return '<a href="javascript:void(0)"' . $html_attributes . '>' . $title . '</a>';
    }
}


/**
 * prepare a anchor tag for modal 
 * 
 * @param string $url
 * @param string $title
 * @param array $attributes
 * @return html link of anchor tag
 */
if (!function_exists('modal_anchor')) {

    function modal_anchor($url, $title = '', $attributes = [])
    {
        if (!get_array_value($attributes, "data-drawer")) {
            $attributes["data-act"] = "ajax-modal";
        } else {
            $attributes["data-act"] = "ajax-drawer";
        }

        if (get_array_value($attributes, "data-modal-title")) {
            $attributes["data-title"] = get_array_value($attributes, "data-modal-title");
        } else {
            $attributes["data-title"] = get_array_value($attributes, "title");
        }
        $attributes["data-action-url"] = $url;

        return js_anchor($title, $attributes);
    }
}

/**
 * prepare a anchor tag for ajax request
 * 
 * @param string $url
 * @param string $title
 * @param array $attributes
 * @return html link of anchor tag
 */
if (!function_exists('ajax_anchor')) {

    function ajax_anchor($url, $title = '', $attributes = [])
    {
        $attributes["data-act"] = "ajax-request";
        $attributes["data-action-url"] = $url;
        return js_anchor($title, $attributes);
    }
}
if (!function_exists('anchor')) {
    /**
     * Anchor Link
     *
     * Creates an anchor based on the local URL.
     *
     * @param	string	the URL
     * @param	string	the link title
     * @param	mixed	any attributes
     * @return	string
     */
    function anchor($uri = '', $title = '', $attributes = [])
    {

        $uri = url($uri);
        $title = (string) $title;
        $html_attributes = "";
        if (1) {
            $attributes['data-bs-toggle'] = "tooltip";
            $attributes['data-bs-custom-class'] = "tooltip-dark";
            $attributes['data-bs-placement'] = "left";
            // unset($attributes['title']);
            // $attributes['data-bs-original-title'] = "qsdqsdqsdqsd";
        }
        if (is_array($attributes)) {
            foreach ($attributes as $key => $value) {
                $html_attributes .= ' ' . $key . '="' . $value . '"';
            }
        }

        return "<a href='$uri' $html_attributes>$title</a>";
    }
}


if (!function_exists('inputs_filter_datatable')) {

    function inputs_filter_datatable($filters = [])
    {
        $ids = [];
        foreach ($filters as $filter) {
            $ids[] = get_array_value($filter, "name");
        }
        return $ids;
    }
}
if (!function_exists('to_date')) {

    function to_date($date = "")
    {
        return DateTime::createFromFormat('d/m/Y', str_replace(" ", "", $date))->format('Y-m-d');
    }
}
if (!function_exists('file_sisze')) {

    function file_sisze($size = 0)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
    }
}

if (!function_exists('row_id')) {
    function row_id($table_name = "table", $id = 0)
    {
        return $table_name . "_row_" . $id;
    }
}
if (!function_exists('get_response_of_question')) {
    function get_response_of_question($questionnaire_id = 0, $project_id = 0)
    {
        return Cache::get(
            'response_of_questionnaire_id_' . $questionnaire_id . 'project_id_' . $project_id, 
            function () use ($questionnaire_id , $project_id ){
                $response = App\Models\ProjectDescription::where("questionnaire_id", $questionnaire_id)->where("project_id", $project_id)->first();
                return $response ? $response->answer : "";
            }
        );
    }
}
