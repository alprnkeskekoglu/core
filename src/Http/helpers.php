<?php

function dawnstar()
{
    return app('Dawnstar');
}

function languageFlag(string $code): string
{
    return "//flagcdn.com/h20/" . ($code == 'en' ? 'gb' : $code) . ".png";
}

function statusClass(int $status): string
{
    switch ($status) {
        case 0:
            return 'danger';
        case 1:
            return 'success';
        case 2:
            return 'secondary';
    }
}

function statusText(int $status): string
{
    return __('Core::general.status_options.' . $status);
}

function adminAction($model, string $type)
{
    $adminActionService = new \Dawnstar\Core\Services\AdminActionService($model);
    $adminActionService->create($type);
}

function searchUrl()
{
    $structure = \Dawnstar\Core\Models\Structure::where('key', 'search')
        ->first();

    if ($structure && $structure->container->translation) {
        return url($structure->container->translation->url->url);
    }
    return "javascript:void(0);";
}

function form(string $key)
{
    return (new \Dawnstar\Core\Foundation\Form($key))->init();
}

function menu(string $key)
{
    return (new \Dawnstar\Core\Foundation\Menu($key))->init();
}

function setSession()
{
    $admin = auth('admin')->user();

    $website = \Dawnstar\Core\Models\Website::where('status', 1)->where('default', 1)->first();
    if ($website) {
        $languages = $website->languages()->orderBy('pivot_default')->get();
        $defaultLanguage = $website->languages()->wherePivot('default', 1)->first();
    }

    if(isset($defaultLanguage) && in_array($defaultLanguage->code, ['tr', 'en'])) {
        $language = $defaultLanguage;
    } else {
        $language = \Dawnstar\Core\Models\Language::where('code', 'tr')->first();
    }

    session([
        'dawnstar' => [
            'admin' => $admin,
            'website' => $website,
            'languages' => $languages ?? [],
            'language' => $language ?? null,
        ]
    ]);
}

function setting(string $key, $default = null): ?string
{
    $websiteId = session('dawnstar.website.id');
    $settings = \Illuminate\Support\Facades\Cache::rememberForever('settings' . $websiteId, function () use ($websiteId) {
        return \Dawnstar\Core\Models\Setting::where('website_id', $websiteId)->pluck('value', 'key')->toArray();
    });

    if (!empty($settings[$key])) {
        return $settings[$key];
    }
    return $default;
}

function canUser(string $key, bool $hasWebsite = true)
{
    $role = auth('admin')->user()->roles->first();

    if ($role->name == 'Super Admin') {
        return true;
    }

    if ($hasWebsite) {
        $key = 'website.' . session('dawnstar.website.id') . '.' . $key;
    }

    if (!$role->hasPermissionTo($key)) {
        throw new \Dawnstar\Core\Exception\PermissionException();
    }
}

function custom(string $key, string $value = null, int $languageId = null)
{
    if (is_null($languageId)) {
        if (str()->startsWith(request()->getPathInfo(), '/dawnstar')) {
            $languageId = session('dawnstar.language.id', 164);
        } else {
            $languageId = dawnstar()->language->id ?? dawnstar()->website()->defaultLanguage()->id;
        }
    }

    $customTranslations = \Illuminate\Support\Facades\Cache::rememberForever('customTranslations_' . $languageId, function () use ($languageId) {
        return \Dawnstar\Core\Models\CustomTranslation::where('language_id', $languageId)->pluck('value', 'key')->toArray();
    });

    if (array_key_exists($key, $customTranslations)) {
        return $customTranslations[$key];
    }

    $customTranslation = \Dawnstar\Core\Models\CustomTranslation::updateOrCreate(
        [
            'language_id' => $languageId,
            'key' => $key
        ],
        [
            'value' => $value
        ]
    );


    $website = dawnstar()->website;

    foreach ($website->languages as $language) {
        \Dawnstar\Core\Models\CustomTranslation::firstOrCreate(
            [
                'language_id' => $languageId,
                'key' => $key
            ]
        );
    }

    \Illuminate\Support\Facades\Cache::forget('customTranslations_' . $languageId);
    return $value;
}

function buildTree(array $elements, $parentId = 0, $max = 0)
{
    $branch = array();
    foreach ($elements as $element) {
        $element['left'] = $max = $max + 1;
        $element['right'] = $max + 1;
        $element['parent_id'] = $parentId;

        if (isset($element['children'])) {
            $children = buildTree($element['children'], $element['id'], $max);
            if ($children) {

                $element['right'] = $max = (isset(end($children)['right']) ? end($children)['right'] : 1) + 1;
                $element['children'] = $children;
            } else {
                $element['right'] = $max = $max + 1;
            }
        }

        $branch[] = $element;
    }

    return unBuildTree($branch);
}

function unBuildTree($elements, $branch = [])
{
    foreach ($elements as $element) {
        if (isset($element['children'])) {
            $branch = unBuildTree($element['children'], $branch);
            unset($element['children']);
        }
        $branch[] = $element;
    }
    return $branch;
}

function panelMenu(): array
{
    return [
        [
            'name' => __('Core::panel_menu.website'),
            'url' => route('dawnstar.websites.index'),
            'icon' => 'mdi mdi-monitor',
            'children' => []
        ],
        [
            'name' => __('Core::panel_menu.structure'),
            'url' => route('dawnstar.structures.index'),
            'icon' => 'mdi mdi-tape-drive',
            'children' => []
        ],
        [
            'name' => __('Core::panel_menu.panel_management'),
            'url' => 'panel_management',
            'icon' => 'mdi mdi-account-lock',
            'children' => [
                [
                    'name' => __('Core::panel_menu.admin'),
                    'url' => route('dawnstar.admins.index')
                ],
                [
                    'name' => __('Core::panel_menu.role'),
                    'url' => route('dawnstar.roles.index')
                ],
                [
                    'name' => __('Core::panel_menu.setting'),
                    'url' => route('dawnstar.settings.index')
                ],
            ]
        ],
        [
            'name' => __('Core::panel_menu.website_management'),
            'url' => 'website_management',
            'icon' => 'mdi mdi-monitor-dashboard',
            'children' => [
                [
                    'name' => __('Core::panel_menu.menu'),
                    'url' => route('dawnstar.menus.index')
                ],
                [
                    'name' => __('Core::panel_menu.form'),
                    'url' => route('dawnstar.forms.index')
                ],
                [
                    'name' => __('Core::panel_menu.custom_translation'),
                    'url' => route('dawnstar.custom_translations.index')
                ],
            ]
        ],
    ];
}

function browserLanguageCodes()
{
    $re = '/([^-;,]*)(?:-([^;]*))?(?:;q=([0-9]\.[0-9]))?/m';
    $str = request()->server('HTTP_ACCEPT_LANGUAGE');

    preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0);

    $list = [];
    foreach ($matches as $match) {
        if (isset($match[1]) && $match[1]) {
            $list[] = $match[1];
        }

    }
    $list = array_values(array_unique($list));

    return $list;
}

function getUniqueId(int $length = 20): string
{
    return substr(md5(uniqid(mt_rand(), true)), 0, $length);
}

function slugify(string $str, string $delimiter = '-'): string
{

    $char_map = array(
        // Latin
        'À' => 'A',
        'Á' => 'A',
        'Â' => 'A',
        'Ã' => 'A',
        'Ä' => 'A',
        'Å' => 'A',
        'Æ' => 'AE',
        'Ç' => 'C',
        'È' => 'E',
        'É' => 'E',
        'Ê' => 'E',
        'Ë' => 'E',
        'Ì' => 'I',
        'Í' => 'I',
        'Î' => 'I',
        'Ï' => 'I',
        'Ð' => 'D',
        'Ñ' => 'N',
        'Ò' => 'O',
        'Ó' => 'O',
        'Ô' => 'O',
        'Õ' => 'O',
        'Ö' => 'O',
        'Ő' => 'O',
        'Ø' => 'O',
        'Ù' => 'U',
        'Ú' => 'U',
        'Û' => 'U',
        'Ü' => 'U',
        'Ű' => 'U',
        'Ý' => 'Y',
        'Þ' => 'TH',
        'ß' => 'ss',
        'à' => 'a',
        'á' => 'a',
        'â' => 'a',
        'ã' => 'a',
        'ä' => 'a',
        'å' => 'a',
        'æ' => 'ae',
        'ç' => 'c',
        'è' => 'e',
        'é' => 'e',
        'ê' => 'e',
        'ë' => 'e',
        'ì' => 'i',
        'í' => 'i',
        'î' => 'i',
        'ï' => 'i',
        'ð' => 'd',
        'ñ' => 'n',
        'ò' => 'o',
        'ó' => 'o',
        'ô' => 'o',
        'õ' => 'o',
        'ö' => 'o',
        'ő' => 'o',
        'ø' => 'o',
        'ù' => 'u',
        'ú' => 'u',
        'û' => 'u',
        'ü' => 'u',
        'ű' => 'u',
        'ý' => 'y',
        'þ' => 'th',
        'ÿ' => 'y',

        // Latin symbols
        '©' => '(c)',

        // Greek
        'Α' => 'A',
        'Β' => 'B',
        'Γ' => 'G',
        'Δ' => 'D',
        'Ε' => 'E',
        'Ζ' => 'Z',
        'Η' => 'H',
        'Θ' => '8',
        'Ι' => 'I',
        'Κ' => 'K',
        'Λ' => 'L',
        'Μ' => 'M',
        'Ν' => 'N',
        'Ξ' => '3',
        'Ο' => 'O',
        'Π' => 'P',
        'Ρ' => 'R',
        'Σ' => 'S',
        'Τ' => 'T',
        'Υ' => 'Y',
        'Φ' => 'F',
        'Χ' => 'X',
        'Ψ' => 'PS',
        'Ω' => 'W',
        'Ά' => 'A',
        'Έ' => 'E',
        'Ί' => 'I',
        'Ό' => 'O',
        'Ύ' => 'Y',
        'Ή' => 'H',
        'Ώ' => 'W',
        'Ϊ' => 'I',
        'Ϋ' => 'Y',
        'α' => 'a',
        'β' => 'b',
        'γ' => 'g',
        'δ' => 'd',
        'ε' => 'e',
        'ζ' => 'z',
        'η' => 'h',
        'θ' => '8',
        'ι' => 'i',
        'κ' => 'k',
        'λ' => 'l',
        'μ' => 'm',
        'ν' => 'n',
        'ξ' => '3',
        'ο' => 'o',
        'π' => 'p',
        'ρ' => 'r',
        'σ' => 's',
        'τ' => 't',
        'υ' => 'y',
        'φ' => 'f',
        'χ' => 'x',
        'ψ' => 'ps',
        'ω' => 'w',
        'ά' => 'a',
        'έ' => 'e',
        'ί' => 'i',
        'ό' => 'o',
        'ύ' => 'y',
        'ή' => 'h',
        'ώ' => 'w',
        'ς' => 's',
        'ϊ' => 'i',
        'ΰ' => 'y',
        'ϋ' => 'y',
        'ΐ' => 'i',

        // Turkish
        'Ş' => 'S',
        'İ' => 'I',
        'Ç' => 'C',
        'Ü' => 'U',
        'Ö' => 'O',
        'Ğ' => 'G',
        'ş' => 's',
        'ı' => 'i',
        'ç' => 'c',
        'ü' => 'u',
        'ö' => 'o',
        'ğ' => 'g',

        // Russian
        'А' => 'A',
        'Б' => 'B',
        'В' => 'V',
        'Г' => 'G',
        'Д' => 'D',
        'Е' => 'E',
        'Ё' => 'Yo',
        'Ж' => 'Zh',
        'З' => 'Z',
        'И' => 'I',
        'Й' => 'J',
        'К' => 'K',
        'Л' => 'L',
        'М' => 'M',
        'Н' => 'N',
        'О' => 'O',
        'П' => 'P',
        'Р' => 'R',
        'С' => 'S',
        'Т' => 'T',
        'У' => 'U',
        'Ф' => 'F',
        'Х' => 'H',
        'Ц' => 'C',
        'Ч' => 'Ch',
        'Ш' => 'Sh',
        'Щ' => 'Sh',
        'Ъ' => '',
        'Ы' => 'Y',
        'Ь' => '',
        'Э' => 'E',
        'Ю' => 'Yu',
        'Я' => 'Ya',
        'а' => 'a',
        'б' => 'b',
        'в' => 'v',
        'г' => 'g',
        'д' => 'd',
        'е' => 'e',
        'ё' => 'yo',
        'ж' => 'zh',
        'з' => 'z',
        'и' => 'i',
        'й' => 'j',
        'к' => 'k',
        'л' => 'l',
        'м' => 'm',
        'н' => 'n',
        'о' => 'o',
        'п' => 'p',
        'р' => 'r',
        'с' => 's',
        'т' => 't',
        'у' => 'u',
        'ф' => 'f',
        'х' => 'h',
        'ц' => 'c',
        'ч' => 'ch',
        'ш' => 'sh',
        'щ' => 'sh',
        'ъ' => '',
        'ы' => 'y',
        'ь' => '',
        'э' => 'e',
        'ю' => 'yu',
        'я' => 'ya',

        // Ukrainian
        'Є' => 'Ye',
        'І' => 'I',
        'Ї' => 'Yi',
        'Ґ' => 'G',
        'є' => 'ye',
        'і' => 'i',
        'ї' => 'yi',
        'ґ' => 'g',

        // Czech
        'Č' => 'C',
        'Ď' => 'D',
        'Ě' => 'E',
        'Ň' => 'N',
        'Ř' => 'R',
        'Š' => 'S',
        'Ť' => 'T',
        'Ů' => 'U',
        'Ž' => 'Z',
        'č' => 'c',
        'ď' => 'd',
        'ě' => 'e',
        'ň' => 'n',
        'ř' => 'r',
        'š' => 's',
        'ť' => 't',
        'ů' => 'u',
        'ž' => 'z',

        // Polish
        'Ą' => 'A',
        'Ć' => 'C',
        'Ę' => 'e',
        'Ł' => 'L',
        'Ń' => 'N',
        'Ó' => 'o',
        'Ś' => 'S',
        'Ź' => 'Z',
        'Ż' => 'Z',
        'ą' => 'a',
        'ć' => 'c',
        'ę' => 'e',
        'ł' => 'l',
        'ń' => 'n',
        'ó' => 'o',
        'ś' => 's',
        'ź' => 'z',
        'ż' => 'z',

        // Latvian
        'Ā' => 'A',
        'Č' => 'C',
        'Ē' => 'E',
        'Ģ' => 'G',
        'Ī' => 'i',
        'Ķ' => 'k',
        'Ļ' => 'L',
        'Ņ' => 'N',
        'Š' => 'S',
        'Ū' => 'u',
        'Ž' => 'Z',
        'ā' => 'a',
        'č' => 'c',
        'ē' => 'e',
        'ģ' => 'g',
        'ī' => 'i',
        'ķ' => 'k',
        'ļ' => 'l',
        'ņ' => 'n',
        'š' => 's',
        'ū' => 'u',
        'ž' => 'z'
    );

    $str = str_replace(array_keys($char_map), $char_map, $str);
    $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $delimiter, $str);
    $str = preg_replace('/(' . preg_quote($delimiter, '/') . '){2,}/', '$1', $str);
    $str = trim($str, $delimiter);

    return mb_strtolower($str, 'UTF-8');
}
