<?php

namespace Dawnstar\Database\seeds;

use Dawnstar\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{

    public function run()
    {
        if(Language::count() != 0) {
            return;
        }

        Language::insert([
            [
                "name" => "Abkhaz",
                "native_name" => "аҧсуа",
                "code" => "ab"
            ],
            [
                "name" => "Afar",
                "native_name" => "Afaraf",
                "code" => "aa"
            ],
            [
                "name" => "Afrikaans",
                "native_name" => "Afrikaans",
                "code" => "af"
            ],
            [
                "name" => "Akan",
                "native_name" => "Akan",
                "code" => "ak"
            ],
            [
                "name" => "Albanian",
                "native_name" => "Shqip",
                "code" => "sq"
            ],
            [
                "name" => "Amharic",
                "native_name" => "አማርኛ",
                "code" => "am"
            ],
            [
                "name" => "Arabic",
                "native_name" => "العربية",
                "code" => "ar"
            ],
            [
                "name" => "Aragonese",
                "native_name" => "Aragonés",
                "code" => "an"
            ],
            [
                "name" => "Armenian",
                "native_name" => "Հայերեն",
                "code" => "hy"
            ],
            [
                "name" => "Assamese",
                "native_name" => "অসমীয়া",
                "code" => "as"
            ],
            [
                "name" => "Avaric",
                "native_name" => "авар мацӀ, магӀарул мацӀ",
                "code" => "av"
            ],
            [
                "name" => "Avestan",
                "native_name" => "avesta",
                "code" => "ae"
            ],
            [
                "name" => "Aymara",
                "native_name" => "aymar aru",
                "code" => "ay"
            ],
            [
                "name" => "Azerbaijani",
                "native_name" => "azərbaycan dili",
                "code" => "az"
            ],
            [
                "name" => "Bambara",
                "native_name" => "bamanankan",
                "code" => "bm"
            ],
            [
                "name" => "Bashkir",
                "native_name" => "башҡорт теле",
                "code" => "ba"
            ],
            [
                "name" => "Basque",
                "native_name" => "euskara, euskera",
                "code" => "eu"
            ],
            [
                "name" => "Belarusian",
                "native_name" => "Беларуская",
                "code" => "be"
            ],
            [
                "name" => "Bengali",
                "native_name" => "বাংলা",
                "code" => "bn"
            ],
            [
                "name" => "Bihari",
                "native_name" => "भोजपुरी",
                "code" => "bh"
            ],
            [
                "name" => "Bislama",
                "native_name" => "Bislama",
                "code" => "bi"
            ],
            [
                "name" => "Bosnian",
                "native_name" => "bosanski jezik",
                "code" => "bs"
            ],
            [
                "name" => "Breton",
                "native_name" => "brezhoneg",
                "code" => "br"
            ],
            [
                "name" => "Bulgarian",
                "native_name" => "български език",
                "code" => "bg"
            ],
            [
                "name" => "Burmese",
                "native_name" => "ဗမာစာ",
                "code" => "my"
            ],
            [
                "name" => "Catalan; Valencian",
                "native_name" => "Català",
                "code" => "ca"
            ],
            [
                "name" => "Chamorro",
                "native_name" => "Chamoru",
                "code" => "ch"
            ],
            [
                "name" => "Chechen",
                "native_name" => "нохчийн мотт",
                "code" => "ce"
            ],
            [
                "name" => "Chichewa; Chewa; Nyanja",
                "native_name" => "chiCheŵa, chinyanja",
                "code" => "ny"
            ],
            [
                "name" => "Chinese",
                "native_name" => "中文 (Zhōngwén), 汉语, 漢語",
                "code" => "zh"
            ],
            [
                "name" => "Chuvash",
                "native_name" => "чӑваш чӗлхи",
                "code" => "cv"
            ],
            [
                "name" => "Cornish",
                "native_name" => "Kernewek",
                "code" => "kw"
            ],
            [
                "name" => "Corsican",
                "native_name" => "corsu, lingua corsa",
                "code" => "co"
            ],
            [
                "name" => "Cree",
                "native_name" => "ᓀᐦᐃᔭᐍᐏᐣ",
                "code" => "cr"
            ],
            [
                "name" => "Croatian",
                "native_name" => "hrvatski",
                "code" => "hr"
            ],
            [
                "name" => "Czech",
                "native_name" => "česky, čeština",
                "code" => "cs"
            ],
            [
                "name" => "Danish",
                "native_name" => "dansk",
                "code" => "da"
            ],
            [
                "name" => "Divehi; Dhivehi; Maldivian;",
                "native_name" => "ދިވެހި",
                "code" => "dv"
            ],
            [
                "name" => "Dutch",
                "native_name" => "Nederlands, Vlaams",
                "code" => "nl"
            ],
            [
                "name" => "English",
                "native_name" => "English",
                "code" => "en"
            ],
            [
                "name" => "Esperanto",
                "native_name" => "Esperanto",
                "code" => "eo"
            ],
            [
                "name" => "Estonian",
                "native_name" => "eesti, eesti keel",
                "code" => "et"
            ],
            [
                "name" => "Ewe",
                "native_name" => "Eʋegbe",
                "code" => "ee"
            ],
            [
                "name" => "Faroese",
                "native_name" => "føroyskt",
                "code" => "fo"
            ],
            [
                "name" => "Fijian",
                "native_name" => "vosa Vakaviti",
                "code" => "fj"
            ],
            [
                "name" => "Finnish",
                "native_name" => "suomi, suomen kieli",
                "code" => "fi"
            ],
            [
                "name" => "French",
                "native_name" => "français, langue française",
                "code" => "fr"
            ],
            [
                "name" => "Fula; Fulah; Pulaar; Pular",
                "native_name" => "Fulfulde, Pulaar, Pular",
                "code" => "ff"
            ],
            [
                "name" => "Galician",
                "native_name" => "Galego",
                "code" => "gl"
            ],
            [
                "name" => "Georgian",
                "native_name" => "ქართული",
                "code" => "ka"
            ],
            [
                "name" => "German",
                "native_name" => "Deutsch",
                "code" => "de"
            ],
            [
                "name" => "Greek, Modern",
                "native_name" => "Ελληνικά",
                "code" => "el"
            ],
            [
                "name" => "Guaraní",
                "native_name" => "Avañeẽ",
                "code" => "gn"
            ],
            [
                "name" => "Gujarati",
                "native_name" => "ગુજરાતી",
                "code" => "gu"
            ],
            [
                "name" => "Haitian; Haitian Creole",
                "native_name" => "Kreyòl ayisyen",
                "code" => "ht"
            ],
            [
                "name" => "Hausa",
                "native_name" => "Hausa, هَوُسَ",
                "code" => "ha"
            ],
            [
                "name" => "Hebrew",
                "native_name" => "עברית",
                "code" => "he"
            ],
            [
                "name" => "Hebrew",
                "native_name" => "עברית",
                "code" => "iw"
            ],
            [
                "name" => "Herero",
                "native_name" => "Otjiherero",
                "code" => "hz"
            ],
            [
                "name" => "Hindi",
                "native_name" => "हिन्दी, हिंदी",
                "code" => "hi"
            ],
            [
                "name" => "Hiri Motu",
                "native_name" => "Hiri Motu",
                "code" => "ho"
            ],
            [
                "name" => "Hungarian",
                "native_name" => "Magyar",
                "code" => "hu"
            ],
            [
                "name" => "Interlingua",
                "native_name" => "Interlingua",
                "code" => "ia"
            ],
            [
                "name" => "Indonesian",
                "native_name" => "Bahasa Indonesia",
                "code" => "id"
            ],
            [
                "name" => "Interlingue",
                "native_name" => "Originally called Occidental; then Interlingue after WWII",
                "code" => "ie"
            ],
            [
                "name" => "Irish",
                "native_name" => "Gaeilge",
                "code" => "ga"
            ],
            [
                "name" => "Igbo",
                "native_name" => "Asụsụ Igbo",
                "code" => "ig"
            ],
            [
                "name" => "Inupiaq",
                "native_name" => "Iñupiaq, Iñupiatun",
                "code" => "ik"
            ],
            [
                "name" => "Ido",
                "native_name" => "Ido",
                "code" => "io"
            ],
            [
                "name" => "Icelandic",
                "native_name" => "Íslenska",
                "code" => "is"
            ],
            [
                "name" => "Italian",
                "native_name" => "Italiano",
                "code" => "it"
            ],
            [
                "name" => "Inuktitut",
                "native_name" => "ᐃᓄᒃᑎᑐᑦ",
                "code" => "iu"
            ],
            [
                "name" => "Japanese",
                "native_name" => "日本語 (にほんご／にっぽんご)",
                "code" => "ja"
            ],
            [
                "name" => "Javanese",
                "native_name" => "basa Jawa",
                "code" => "jv"
            ],
            [
                "name" => "Kalaallisut, Greenlandic",
                "native_name" => "kalaallisut, kalaallit oqaasii",
                "code" => "kl"
            ],
            [
                "name" => "Kannada",
                "native_name" => "ಕನ್ನಡ",
                "code" => "kn"
            ],
            [
                "name" => "Kanuri",
                "native_name" => "Kanuri",
                "code" => "kr"
            ],
            [
                "name" => "Kashmiri",
                "native_name" => "कश्मीरी, كشميري‎",
                "code" => "ks"
            ],
            [
                "name" => "Kazakh",
                "native_name" => "Қазақ тілі",
                "code" => "kk"
            ],
            [
                "name" => "Khmer",
                "native_name" => "ភាសាខ្មែរ",
                "code" => "km"
            ],
            [
                "name" => "Kikuyu, Gikuyu",
                "native_name" => "Gĩkũyũ",
                "code" => "ki"
            ],
            [
                "name" => "Kinyarwanda",
                "native_name" => "Ikinyarwanda",
                "code" => "rw"
            ],
            [
                "name" => "Kirghiz, Kyrgyz",
                "native_name" => "кыргыз тили",
                "code" => "ky"
            ],
            [
                "name" => "Komi",
                "native_name" => "коми кыв",
                "code" => "kv"
            ],
            [
                "name" => "Kongo",
                "native_name" => "KiKongo",
                "code" => "kg"
            ],
            [
                "name" => "Korean",
                "native_name" => "한국어 (韓國語), 조선말 (朝鮮語)",
                "code" => "ko"
            ],
            [
                "name" => "Kurdish",
                "native_name" => "Kurdî, كوردی‎",
                "code" => "ku"
            ],
            [
                "name" => "Kwanyama, Kuanyama",
                "native_name" => "Kuanyama",
                "code" => "kj"
            ],
            [
                "name" => "Latin",
                "native_name" => "latine, lingua latina",
                "code" => "la"
            ],
            [
                "name" => "Luxembourgish, Letzeburgesch",
                "native_name" => "Lëtzebuergesch",
                "code" => "lb"
            ],
            [
                "name" => "Luganda",
                "native_name" => "Luganda",
                "code" => "lg"
            ],
            [
                "name" => "Limburgish, Limburgan, Limburger",
                "native_name" => "Limburgs",
                "code" => "li"
            ],
            [
                "name" => "Lingala",
                "native_name" => "Lingála",
                "code" => "ln"
            ],
            [
                "name" => "Lao",
                "native_name" => "ພາສາລາວ",
                "code" => "lo"
            ],
            [
                "name" => "Lithuanian",
                "native_name" => "lietuvių kalba",
                "code" => "lt"
            ],
            [
                "name" => "Luba-Katanga",
                "native_name" => "",
                "code" => "lu"
            ],
            [
                "name" => "Latvian",
                "native_name" => "latviešu valoda",
                "code" => "lv"
            ],
            [
                "name" => "Manx",
                "native_name" => "Gaelg, Gailck",
                "code" => "gv"
            ],
            [
                "name" => "Macedonian",
                "native_name" => "македонски јазик",
                "code" => "mk"
            ],
            [
                "name" => "Malagasy",
                "native_name" => "Malagasy fiteny",
                "code" => "mg"
            ],
            [
                "name" => "Malay",
                "native_name" => "bahasa Melayu, بهاس ملايو‎",
                "code" => "ms"
            ],
            [
                "name" => "Malayalam",
                "native_name" => "മലയാളം",
                "code" => "ml"
            ],
            [
                "name" => "Maltese",
                "native_name" => "Malti",
                "code" => "mt"
            ],
            [
                "name" => "Māori",
                "native_name" => "te reo Māori",
                "code" => "mi"
            ],
            [
                "name" => "Marathi (Marāṭhī)",
                "native_name" => "मराठी",
                "code" => "mr"
            ],
            [
                "name" => "Marshallese",
                "native_name" => "Kajin M̧ajeļ",
                "code" => "mh"
            ],
            [
                "name" => "Mongolian",
                "native_name" => "монгол",
                "code" => "mn"
            ],
            [
                "name" => "Nauru",
                "native_name" => "Ekakairũ Naoero",
                "code" => "na"
            ],
            [
                "name" => "Navajo, Navaho",
                "native_name" => "Diné bizaad, Dinékʼehǰí",
                "code" => "nv"
            ],
            [
                "name" => "Norwegian Bokmål",
                "native_name" => "Norsk bokmål",
                "code" => "nb"
            ],
            [
                "name" => "North Ndebele",
                "native_name" => "isiNdebele",
                "code" => "nd"
            ],
            [
                "name" => "Nepali",
                "native_name" => "नेपाली",
                "code" => "ne"
            ],
            [
                "name" => "Ndonga",
                "native_name" => "Owambo",
                "code" => "ng"
            ],
            [
                "name" => "Norwegian Nynorsk",
                "native_name" => "Norsk nynorsk",
                "code" => "nn"
            ],
            [
                "name" => "Norwegian",
                "native_name" => "Norsk",
                "code" => "no"
            ],
            [
                "name" => "Nuosu",
                "native_name" => "ꆈꌠ꒿ Nuosuhxop",
                "code" => "ii"
            ],
            [
                "name" => "South Ndebele",
                "native_name" => "isiNdebele",
                "code" => "nr"
            ],
            [
                "name" => "Occitan",
                "native_name" => "Occitan",
                "code" => "oc"
            ],
            [
                "name" => "Ojibwe, Ojibwa",
                "native_name" => "ᐊᓂᔑᓈᐯᒧᐎᓐ",
                "code" => "oj"
            ],
            [
                "name" => "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic",
                "native_name" => "ѩзыкъ словѣньскъ",
                "code" => "cu"
            ],
            [
                "name" => "Oromo",
                "native_name" => "Afaan Oromoo",
                "code" => "om"
            ],
            [
                "name" => "Oriya",
                "native_name" => "ଓଡ଼ିଆ",
                "code" => "or"
            ],
            [
                "name" => "Ossetian, Ossetic",
                "native_name" => "ирон æвзаг",
                "code" => "os"
            ],
            [
                "name" => "Panjabi, Punjabi",
                "native_name" => "ਪੰਜਾਬੀ, پنجابی‎",
                "code" => "pa"
            ],
            [
                "name" => "Pāli",
                "native_name" => "पाऴि",
                "code" => "pi"
            ],
            [
                "name" => "Persian",
                "native_name" => "فارسی",
                "code" => "fa"
            ],
            [
                "name" => "Polish",
                "native_name" => "polski",
                "code" => "pl"
            ],
            [
                "name" => "Pashto, Pushto",
                "native_name" => "پښتو",
                "code" => "ps"
            ],
            [
                "name" => "Portuguese",
                "native_name" => "Português",
                "code" => "pt"
            ],
            [
                "name" => "Quechua",
                "native_name" => "Runa Simi, Kichwa",
                "code" => "qu"
            ],
            [
                "name" => "Romansh",
                "native_name" => "rumantsch grischun",
                "code" => "rm"
            ],
            [
                "name" => "Kirundi",
                "native_name" => "kiRundi",
                "code" => "rn"
            ],
            [
                "name" => "Romanian, Moldavian, Moldovan",
                "native_name" => "română",
                "code" => "ro"
            ],
            [
                "name" => "Russian",
                "native_name" => "русский язык",
                "code" => "ru"
            ],
            [
                "name" => "Sanskrit (Saṁskṛta)",
                "native_name" => "संस्कृतम्",
                "code" => "sa"
            ],
            [
                "name" => "Sardinian",
                "native_name" => "sardu",
                "code" => "sc"
            ],
            [
                "name" => "Sindhi",
                "native_name" => "सिन्धी, سنڌي، سندھی‎",
                "code" => "sd"
            ],
            [
                "name" => "Northern Sami",
                "native_name" => "Davvisámegiella",
                "code" => "se"
            ],
            [
                "name" => "Samoan",
                "native_name" => "gagana faa Samoa",
                "code" => "sm"
            ],
            [
                "name" => "Sango",
                "native_name" => "yângâ tî sängö",
                "code" => "sg"
            ],
            [
                "name" => "Serbian",
                "native_name" => "српски језик",
                "code" => "sr"
            ],
            [
                "name" => "Scottish Gaelic; Gaelic",
                "native_name" => "Gàidhlig",
                "code" => "gd"
            ],
            [
                "name" => "Shona",
                "native_name" => "chiShona",
                "code" => "sn"
            ],
            [
                "name" => "Sinhala, Sinhalese",
                "native_name" => "සිංහල",
                "code" => "si"
            ],
            [
                "name" => "Slovak",
                "native_name" => "slovenčina",
                "code" => "sk"
            ],
            [
                "name" => "Slovene",
                "native_name" => "slovenščina",
                "code" => "sl"
            ],
            [
                "name" => "Somali",
                "native_name" => "Soomaaliga, af Soomaali",
                "code" => "so"
            ],
            [
                "name" => "Southern Sotho",
                "native_name" => "Sesotho",
                "code" => "st"
            ],
            [
                "name" => "Spanish; Castilian",
                "native_name" => "español, castellano",
                "code" => "es"
            ],
            [
                "name" => "Sundanese",
                "native_name" => "Basa Sunda",
                "code" => "su"
            ],
            [
                "name" => "Swahili",
                "native_name" => "Kiswahili",
                "code" => "sw"
            ],
            [
                "name" => "Swati",
                "native_name" => "SiSwati",
                "code" => "ss"
            ],
            [
                "name" => "Swedish",
                "native_name" => "svenska",
                "code" => "sv"
            ],
            [
                "name" => "Tamil",
                "native_name" => "தமிழ்",
                "code" => "ta"
            ],
            [
                "name" => "Telugu",
                "native_name" => "తెలుగు",
                "code" => "te"
            ],
            [
                "name" => "Tajik",
                "native_name" => "тоҷикӣ, toğikī, تاجیکی‎",
                "code" => "tg"
            ],
            [
                "name" => "Thai",
                "native_name" => "ไทย",
                "code" => "th"
            ],
            [
                "name" => "Tigrinya",
                "native_name" => "ትግርኛ",
                "code" => "ti"
            ],
            [
                "name" => "Tibetan Standard, Tibetan, Central",
                "native_name" => "བོད་ཡིག",
                "code" => "bo"
            ],
            [
                "name" => "Turkmen",
                "native_name" => "Türkmen, Түркмен",
                "code" => "tk"
            ],
            [
                "name" => "Tagalog",
                "native_name" => "Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔",
                "code" => "tl"
            ],
            [
                "name" => "Tswana",
                "native_name" => "Setswana",
                "code" => "tn"
            ],
            [
                "name" => "Tonga (Tonga Islands)",
                "native_name" => "faka Tonga",
                "code" => "to"
            ],
            [
                "name" => "Turkish",
                "native_name" => "Türkçe",
                "code" => "tr"
            ],
            [
                "name" => "Tsonga",
                "native_name" => "Xitsonga",
                "code" => "ts"
            ],
            [
                "name" => "Tatar",
                "native_name" => "татарча, tatarça, تاتارچا‎",
                "code" => "tt"
            ],
            [
                "name" => "Twi",
                "native_name" => "Twi",
                "code" => "tw"
            ],
            [
                "name" => "Tahitian",
                "native_name" => "Reo Tahiti",
                "code" => "ty"
            ],
            [
                "name" => "Uighur, Uyghur",
                "native_name" => "Uyƣurqə, ئۇيغۇرچە‎",
                "code" => "ug"
            ],
            [
                "name" => "Ukrainian",
                "native_name" => "українська",
                "code" => "uk"
            ],
            [
                "name" => "Urdu",
                "native_name" => "اردو",
                "code" => "ur"
            ],
            [
                "name" => "Uzbek",
                "native_name" => "zbek, Ўзбек, أۇزبېك‎",
                "code" => "uz"
            ],
            [
                "name" => "Venda",
                "native_name" => "Tshivenḓa",
                "code" => "ve"
            ],
            [
                "name" => "Vietnamese",
                "native_name" => "Tiếng Việt",
                "code" => "vi"
            ],
            [
                "name" => "Volapük",
                "native_name" => "Volapük",
                "code" => "vo"
            ],
            [
                "name" => "Walloon",
                "native_name" => "Walon",
                "code" => "wa"
            ],
            [
                "name" => "Welsh",
                "native_name" => "Cymraeg",
                "code" => "cy"
            ],
            [
                "name" => "Wolof",
                "native_name" => "Wollof",
                "code" => "wo"
            ],
            [
                "name" => "Western Frisian",
                "native_name" => "Frysk",
                "code" => "fy"
            ],
            [
                "name" => "Xhosa",
                "native_name" => "isiXhosa",
                "code" => "xh"
            ],
            [
                "name" => "Yiddish",
                "native_name" => "ייִדיש",
                "code" => "yi"
            ],
            [
                "name" => "Yoruba",
                "native_name" => "Yorùbá",
                "code" => "yo"
            ],
            [
                "name" => "Zhuang, Chuang",
                "native_name" => "Saɯ cueŋƅ, Saw cuengh",
                "code" => "za"
            ]
        ]);
    }
}
