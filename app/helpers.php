<?php

if (! function_exists('markdown')) {
    /**
     * Compile the given text to markdown document.
     *
     * @param string $text
     * @return string
     */
    function markdown($text)
    {
        return app(ParsedownExtra::class)->text($text);
    }
}

if (! function_exists('icon')) {
    /**
     * Generate FontAwesome icon tag
     *
     * @param string $class    font-awesome class name
     * @param string $addition additional class
     * @param string $inline   inline style
     * @return string
     */
    function icon($class, $addition = 'icon', $inline = null)
    {
        $icon = config('icons.' . $class);
        $inline = $inline ? 'style="' . $inline . '"' : null;

        return sprintf('<i class="%s %s" %s></i>', $icon, $addition, $inline);
    }
}

if (! function_exists('attachment_path')) {
    /**
     * @param string $path
     *
     * @return string
     */
    function attachment_path($path = '')
    {
        return public_path($path ? 'attachments' . DIRECTORY_SEPARATOR . $path : 'attachments');
    }
}

if (! function_exists('gravatar_profile_url')) {
    /**
     * Get gravatar profile page url
     *
     * @param  string $email
     * @return string
     */
    function gravatar_profile_url($email)
    {
        return sprintf("//www.gravatar.com/%s", md5($email));
    }
}

if (! function_exists('gravatar_url')) {
    /**
     * Get gravatar image url
     *
     * @param  string  $email
     * @param  integer $size
     * @return string
     */
    function gravatar_url($email, $size = 48)
    {
        return sprintf("//www.gravatar.com/avatar/%s?s=%s", md5($email), $size);
    }
}

if (! function_exists('taggable')) {
    /**
     * Determine if the current cache driver has cacheTags() method
     *
     * @return bool
     */
    function taggable()
    {
        return ! in_array(config('cache.default'), ['file', 'database']);
    }
}

if (! function_exists('link_for_sort')) {
    /**
     * Build HTML anchor tag for sorting
     *
     * @param string $column
     * @param string $text
     * @param array  $params
     * @return string
     */
    function link_for_sort($column, $text, $params = [])
    {
        $config = config('project.params');

        $direction = request()->input($config['order']);
        $reverse = ($direction == 'asc') ? 'desc' : 'asc';

        if (request()->input($config['sort']) == $column) {
            // Update passed $text var, only if it is active sort
            $text = sprintf(
                "%s %s",
                $direction == 'asc' ? icon('asc') : icon('desc'),
                $text
            );
        }

        $queryString = http_build_query(array_merge(
            request()->except([$config['page'], $config['sort'], $config['order']]),
            [$config['sort'] => $column, $config['order'] => $reverse],
            $params
        ));

        return sprintf(
            '<a href="%s?%s">%s</a>',
            urldecode(request()->url()),
            $queryString,
            $text
        );
    }
}

if (! function_exists('current_url')) {
    /**
     * Build current url string, without return param.
     *
     * @return string
     */
    function current_url()
    {
        if (! request()->has('return')) {
            return request()->fullUrl();
        }

        return sprintf(
            '%s?%s',
            request()->url(),
            http_build_query(request()->except('return'))
        );
    }
}

if (! function_exists('is_api_request')) {
    /**
     * Determine if the current request is for HTTP api.
     *
     * @return bool
     */
    function is_api_request()
    {
        return starts_with(request()->getHttpHost(), config('project.api_domain'));
    }
}

if (! function_exists('optimus')) {
    /**
     * Create Optimus instance.
     *
     * @param int|null $id
     * @return int|\Jenssegers\Optimus\Optimus
     */
    function optimus($id = null)
    {
        $factory = app(\Jenssegers\Optimus\Optimus::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->encode($id);
    }
}

if (! function_exists('cache_key')) {
    /**
     * Generate key for caching.
     *
     * Note. Even though the request endpoints are the same,
     *       the response body should be different because of the query string.
     *
     * @param $base
     * @return string
     */
    function cache_key($base)
    {
        $key = ($uri = request()->fullUrl())
            ? $base . '.' . urlencode($uri)
            : $base;

        return md5($key);
    }
}

if(! function_exists('han_slug')){
  function han_slug($str, $options = [])
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = [
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => [],
            'transliterate' => true,
        ];
        // Merge options
        $options = array_merge($defaults, $options);

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = han2eng($str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }

    function han2eng($text)
    {
        /* 초중성에 대응하는 영문 알파벳 배열화 */
        // $LCtable = array("ㄱ", "ㄲ", "ㄴ", "ㄷ", "ㄸ", "ㄹ", "ㅁ", "ㅂ", "ㅃ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅉ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ");
        // $MVtable = array("ㅏ", "ㅐ", "ㅑ", "ㅒ", "ㅓ", "ㅔ", "ㅕ", "ㅖ", "ㅗ", "ㅘ", "ㅙ", "ㅚ", "ㅛ", "ㅜ", "ㅝ", "ㅞ", "ㅟ", "ㅠ", "ㅡ", "ㅢ", "ㅣ");
        // $TCtable = array("", "ㄱ", "ㄲ", "ㄳ", "ㄴ", "ㄵ", "ㄶ", "ㄷ", "ㄹ", "ㄺ", "ㄻ", "ㄼ", "ㄽ", "ㄾ", "ㄿ", "ㅀ", "ㅁ", "ㅂ", "ㅄ", "ㅅ", "ㅆ", "ㅇ", "ㅈ", "ㅊ", "ㅋ", "ㅌ", "ㅍ", "ㅎ");

        $LCetable = ["k", "kk", "n", "d", "tt", "l", "m", "b", "pp", "s", "ss", "", "j", "jj", "ch", "k", "t", "p", "h"];
        $MVetable = ["a", "ae", "ya", "yae", "eo", "e", "yeo", "ye", "o", "wa", "wae", "oe", "yo", "u", "wo", "we", "wi", "yu", "eu", "ui", "i"];
        $TCetable = ["", "g", "kk", "k", "n", "n", "n", "t", "l", "l", "l", "l", "l", "l", "l", "l", "m", "p", "p", "s", "ss", "ng", "j", "ch", "k", "t", "p", "h"];

        $returnValue = '';

        // UTF-8로 변환된 문장을 유니코드로 변환한다.
        $result = utf8ToUnicode($text);

        // 유니코드로 변환된 글이 한글코드 안에 있으면 초중성으로 분리한다
        // 원본에서 약간 수정함. 한글 외 글자에서 중복패턴이 나오는 부분 수정함.
        // 단, 한글외 [0-9a-Z]는 확인했지만 그 외 문자에서는 확인 해 보지 않음.
        foreach ($result AS $key => $val) {
            if ($val >= 44032 && $val <= 55203) {
                $chr = "";
                $code = $val;
                $temp1 = $code - 44032;
                $T = (int)$temp1 % 28;
                $temp1 /= 28;
                $V = (int)$temp1 % 21;
                $temp1 /= 21;
                $L = (int)$temp1;
                $chr .= $LCetable[$L] . $MVetable[$V] . $TCetable[$T];

                $returnValue .= ucfirst($chr);
            } else {
                $returnValue .= chr($val);
            }
        }
        return $returnValue;
    }

    function utf8ToUnicode($str)
    {
        $unicode = [];
        $values = [];
        $lookingFor = 1;

        for ($i = 0; $i < strlen($str); $i++) {
            $thisValue = ord($str[$i]);
            if ($thisValue < 128) {
                $unicode[] = $thisValue;
            } else {
                if (count($values) == 0) {
                    $lookingFor = ($thisValue < 224) ? 2 : 3;
                }
                $values[] = $thisValue;
                if (count($values) == $lookingFor) {

                    $number = ($lookingFor == 3) ?
                        (($values[0] % 16) * 4096) + (($values[1] % 64) * 64) + ($values[2] % 64) :
                        (($values[0] % 32) * 64) + ($values[1] % 64);

                    $unicode[] = $number;
                    $values = [];
                    $lookingFor = 1;
                }
            }
        }
        return $unicode;
    }
}
