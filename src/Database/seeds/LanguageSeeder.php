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
                "name_en" => "Abkhaz",
                "native_name" => "аҧсуа",
                "code" => "ab"
            ],
            [
                "name_en" => "Afar",
                "native_name" => "Afaraf",
                "code" => "aa"
            ],
            [
                "name_en" => "Afrikaans",
                "native_name" => "Afrikaans",
                "code" => "af"
            ],
            [
                "name_en" => "Akan",
                "native_name" => "Akan",
                "code" => "ak"
            ],
            [
                "name_en" => "Albanian",
                "native_name" => "Shqip",
                "code" => "sq"
            ],
            [
                "name_en" => "Amharic",
                "native_name" => "አማርኛ",
                "code" => "am"
            ],
            [
                "name_en" => "Arabic",
                "native_name" => "العربية",
                "code" => "ar"
            ],
            [
                "name_en" => "Aragonese",
                "native_name" => "Aragonés",
                "code" => "an"
            ],
            [
                "name_en" => "Armenian",
                "native_name" => "Հայերեն",
                "code" => "hy"
            ],
            [
                "name_en" => "Assamese",
                "native_name" => "অসমীয়া",
                "code" => "as"
            ],
            [
                "name_en" => "Avaric",
                "native_name" => "авар мацӀ, магӀарул мацӀ",
                "code" => "av"
            ],
            [
                "name_en" => "Avestan",
                "native_name" => "avesta",
                "code" => "ae"
            ],
            [
                "name_en" => "Aymara",
                "native_name" => "aymar aru",
                "code" => "ay"
            ],
            [
                "name_en" => "Azerbaijani",
                "native_name" => "azərbaycan dili",
                "code" => "az"
            ],
            [
                "name_en" => "Bambara",
                "native_name" => "bamanankan",
                "code" => "bm"
            ],
            [
                "name_en" => "Bashkir",
                "native_name" => "башҡорт теле",
                "code" => "ba"
            ],
            [
                "name_en" => "Basque",
                "native_name" => "euskara, euskera",
                "code" => "eu"
            ],
            [
                "name_en" => "Belarusian",
                "native_name" => "Беларуская",
                "code" => "be"
            ],
            [
                "name_en" => "Bengali",
                "native_name" => "বাংলা",
                "code" => "bn"
            ],
            [
                "name_en" => "Bihari",
                "native_name" => "भोजपुरी",
                "code" => "bh"
            ],
            [
                "name_en" => "Bislama",
                "native_name" => "Bislama",
                "code" => "bi"
            ],
            [
                "name_en" => "Bosnian",
                "native_name" => "bosanski jezik",
                "code" => "bs"
            ],
            [
                "name_en" => "Breton",
                "native_name" => "brezhoneg",
                "code" => "br"
            ],
            [
                "name_en" => "Bulgarian",
                "native_name" => "български език",
                "code" => "bg"
            ],
            [
                "name_en" => "Burmese",
                "native_name" => "ဗမာစာ",
                "code" => "my"
            ],
            [
                "name_en" => "Catalan; Valencian",
                "native_name" => "Català",
                "code" => "ca"
            ],
            [
                "name_en" => "Chamorro",
                "native_name" => "Chamoru",
                "code" => "ch"
            ],
            [
                "name_en" => "Chechen",
                "native_name" => "нохчийн мотт",
                "code" => "ce"
            ],
            [
                "name_en" => "Chichewa; Chewa; Nyanja",
                "native_name" => "chiCheŵa, chinyanja",
                "code" => "ny"
            ],
            [
                "name_en" => "Chinese",
                "native_name" => "中文 (Zhōngwén), 汉语, 漢語",
                "code" => "zh"
            ],
            [
                "name_en" => "Chuvash",
                "native_name" => "чӑваш чӗлхи",
                "code" => "cv"
            ],
            [
                "name_en" => "Cornish",
                "native_name" => "Kernewek",
                "code" => "kw"
            ],
            [
                "name_en" => "Corsican",
                "native_name" => "corsu, lingua corsa",
                "code" => "co"
            ],
            [
                "name_en" => "Cree",
                "native_name" => "ᓀᐦᐃᔭᐍᐏᐣ",
                "code" => "cr"
            ],
            [
                "name_en" => "Croatian",
                "native_name" => "hrvatski",
                "code" => "hr"
            ],
            [
                "name_en" => "Czech",
                "native_name" => "česky, čeština",
                "code" => "cs"
            ],
            [
                "name_en" => "Danish",
                "native_name" => "dansk",
                "code" => "da"
            ],
            [
                "name_en" => "Divehi; Dhivehi; Maldivian;",
                "native_name" => "ދިވެހި",
                "code" => "dv"
            ],
            [
                "name_en" => "Dutch",
                "native_name" => "Nederlands, Vlaams",
                "code" => "nl"
            ],
            [
                "name_en" => "English",
                "native_name" => "English",
                "code" => "en"
            ],
            [
                "name_en" => "Esperanto",
                "native_name" => "Esperanto",
                "code" => "eo"
            ],
            [
                "name_en" => "Estonian",
                "native_name" => "eesti, eesti keel",
                "code" => "et"
            ],
            [
                "name_en" => "Ewe",
                "native_name" => "Eʋegbe",
                "code" => "ee"
            ],
            [
                "name_en" => "Faroese",
                "native_name" => "føroyskt",
                "code" => "fo"
            ],
            [
                "name_en" => "Fijian",
                "native_name" => "vosa Vakaviti",
                "code" => "fj"
            ],
            [
                "name_en" => "Finnish",
                "native_name" => "suomi, suomen kieli",
                "code" => "fi"
            ],
            [
                "name_en" => "French",
                "native_name" => "français, langue française",
                "code" => "fr"
            ],
            [
                "name_en" => "Fula; Fulah; Pulaar; Pular",
                "native_name" => "Fulfulde, Pulaar, Pular",
                "code" => "ff"
            ],
            [
                "name_en" => "Galician",
                "native_name" => "Galego",
                "code" => "gl"
            ],
            [
                "name_en" => "Georgian",
                "native_name" => "ქართული",
                "code" => "ka"
            ],
            [
                "name_en" => "German",
                "native_name" => "Deutsch",
                "code" => "de"
            ],
            [
                "name_en" => "Greek, Modern",
                "native_name" => "Ελληνικά",
                "code" => "el"
            ],
            [
                "name_en" => "Guaraní",
                "native_name" => "Avañeẽ",
                "code" => "gn"
            ],
            [
                "name_en" => "Gujarati",
                "native_name" => "ગુજરાતી",
                "code" => "gu"
            ],
            [
                "name_en" => "Haitian; Haitian Creole",
                "native_name" => "Kreyòl ayisyen",
                "code" => "ht"
            ],
            [
                "name_en" => "Hausa",
                "native_name" => "Hausa, هَوُسَ",
                "code" => "ha"
            ],
            [
                "name_en" => "Hebrew",
                "native_name" => "עברית",
                "code" => "he"
            ],
            [
                "name_en" => "Hebrew",
                "native_name" => "עברית",
                "code" => "iw"
            ],
            [
                "name_en" => "Herero",
                "native_name" => "Otjiherero",
                "code" => "hz"
            ],
            [
                "name_en" => "Hindi",
                "native_name" => "हिन्दी, हिंदी",
                "code" => "hi"
            ],
            [
                "name_en" => "Hiri Motu",
                "native_name" => "Hiri Motu",
                "code" => "ho"
            ],
            [
                "name_en" => "Hungarian",
                "native_name" => "Magyar",
                "code" => "hu"
            ],
            [
                "name_en" => "Interlingua",
                "native_name" => "Interlingua",
                "code" => "ia"
            ],
            [
                "name_en" => "Indonesian",
                "native_name" => "Bahasa Indonesia",
                "code" => "id"
            ],
            [
                "name_en" => "Interlingue",
                "native_name" => "Originally called Occidental; then Interlingue after WWII",
                "code" => "ie"
            ],
            [
                "name_en" => "Irish",
                "native_name" => "Gaeilge",
                "code" => "ga"
            ],
            [
                "name_en" => "Igbo",
                "native_name" => "Asụsụ Igbo",
                "code" => "ig"
            ],
            [
                "name_en" => "Inupiaq",
                "native_name" => "Iñupiaq, Iñupiatun",
                "code" => "ik"
            ],
            [
                "name_en" => "Ido",
                "native_name" => "Ido",
                "code" => "io"
            ],
            [
                "name_en" => "Icelandic",
                "native_name" => "Íslenska",
                "code" => "is"
            ],
            [
                "name_en" => "Italian",
                "native_name" => "Italiano",
                "code" => "it"
            ],
            [
                "name_en" => "Inuktitut",
                "native_name" => "ᐃᓄᒃᑎᑐᑦ",
                "code" => "iu"
            ],
            [
                "name_en" => "Japanese",
                "native_name" => "日本語 (にほんご／にっぽんご)",
                "code" => "ja"
            ],
            [
                "name_en" => "Javanese",
                "native_name" => "basa Jawa",
                "code" => "jv"
            ],
            [
                "name_en" => "Kalaallisut, Greenlandic",
                "native_name" => "kalaallisut, kalaallit oqaasii",
                "code" => "kl"
            ],
            [
                "name_en" => "Kannada",
                "native_name" => "ಕನ್ನಡ",
                "code" => "kn"
            ],
            [
                "name_en" => "Kanuri",
                "native_name" => "Kanuri",
                "code" => "kr"
            ],
            [
                "name_en" => "Kashmiri",
                "native_name" => "कश्मीरी, كشميري‎",
                "code" => "ks"
            ],
            [
                "name_en" => "Kazakh",
                "native_name" => "Қазақ тілі",
                "code" => "kk"
            ],
            [
                "name_en" => "Khmer",
                "native_name" => "ភាសាខ្មែរ",
                "code" => "km"
            ],
            [
                "name_en" => "Kikuyu, Gikuyu",
                "native_name" => "Gĩkũyũ",
                "code" => "ki"
            ],
            [
                "name_en" => "Kinyarwanda",
                "native_name" => "Ikinyarwanda",
                "code" => "rw"
            ],
            [
                "name_en" => "Kirghiz, Kyrgyz",
                "native_name" => "кыргыз тили",
                "code" => "ky"
            ],
            [
                "name_en" => "Komi",
                "native_name" => "коми кыв",
                "code" => "kv"
            ],
            [
                "name_en" => "Kongo",
                "native_name" => "KiKongo",
                "code" => "kg"
            ],
            [
                "name_en" => "Korean",
                "native_name" => "한국어 (韓國語), 조선말 (朝鮮語)",
                "code" => "ko"
            ],
            [
                "name_en" => "Kurdish",
                "native_name" => "Kurdî, كوردی‎",
                "code" => "ku"
            ],
            [
                "name_en" => "Kwanyama, Kuanyama",
                "native_name" => "Kuanyama",
                "code" => "kj"
            ],
            [
                "name_en" => "Latin",
                "native_name" => "latine, lingua latina",
                "code" => "la"
            ],
            [
                "name_en" => "Luxembourgish, Letzeburgesch",
                "native_name" => "Lëtzebuergesch",
                "code" => "lb"
            ],
            [
                "name_en" => "Luganda",
                "native_name" => "Luganda",
                "code" => "lg"
            ],
            [
                "name_en" => "Limburgish, Limburgan, Limburger",
                "native_name" => "Limburgs",
                "code" => "li"
            ],
            [
                "name_en" => "Lingala",
                "native_name" => "Lingála",
                "code" => "ln"
            ],
            [
                "name_en" => "Lao",
                "native_name" => "ພາສາລາວ",
                "code" => "lo"
            ],
            [
                "name_en" => "Lithuanian",
                "native_name" => "lietuvių kalba",
                "code" => "lt"
            ],
            [
                "name_en" => "Luba-Katanga",
                "native_name" => "",
                "code" => "lu"
            ],
            [
                "name_en" => "Latvian",
                "native_name" => "latviešu valoda",
                "code" => "lv"
            ],
            [
                "name_en" => "Manx",
                "native_name" => "Gaelg, Gailck",
                "code" => "gv"
            ],
            [
                "name_en" => "Macedonian",
                "native_name" => "македонски јазик",
                "code" => "mk"
            ],
            [
                "name_en" => "Malagasy",
                "native_name" => "Malagasy fiteny",
                "code" => "mg"
            ],
            [
                "name_en" => "Malay",
                "native_name" => "bahasa Melayu, بهاس ملايو‎",
                "code" => "ms"
            ],
            [
                "name_en" => "Malayalam",
                "native_name" => "മലയാളം",
                "code" => "ml"
            ],
            [
                "name_en" => "Maltese",
                "native_name" => "Malti",
                "code" => "mt"
            ],
            [
                "name_en" => "Māori",
                "native_name" => "te reo Māori",
                "code" => "mi"
            ],
            [
                "name_en" => "Marathi (Marāṭhī)",
                "native_name" => "मराठी",
                "code" => "mr"
            ],
            [
                "name_en" => "Marshallese",
                "native_name" => "Kajin M̧ajeļ",
                "code" => "mh"
            ],
            [
                "name_en" => "Mongolian",
                "native_name" => "монгол",
                "code" => "mn"
            ],
            [
                "name_en" => "Nauru",
                "native_name" => "Ekakairũ Naoero",
                "code" => "na"
            ],
            [
                "name_en" => "Navajo, Navaho",
                "native_name" => "Diné bizaad, Dinékʼehǰí",
                "code" => "nv"
            ],
            [
                "name_en" => "Norwegian Bokmål",
                "native_name" => "Norsk bokmål",
                "code" => "nb"
            ],
            [
                "name_en" => "North Ndebele",
                "native_name" => "isiNdebele",
                "code" => "nd"
            ],
            [
                "name_en" => "Nepali",
                "native_name" => "नेपाली",
                "code" => "ne"
            ],
            [
                "name_en" => "Ndonga",
                "native_name" => "Owambo",
                "code" => "ng"
            ],
            [
                "name_en" => "Norwegian Nynorsk",
                "native_name" => "Norsk nynorsk",
                "code" => "nn"
            ],
            [
                "name_en" => "Norwegian",
                "native_name" => "Norsk",
                "code" => "no"
            ],
            [
                "name_en" => "Nuosu",
                "native_name" => "ꆈꌠ꒿ Nuosuhxop",
                "code" => "ii"
            ],
            [
                "name_en" => "South Ndebele",
                "native_name" => "isiNdebele",
                "code" => "nr"
            ],
            [
                "name_en" => "Occitan",
                "native_name" => "Occitan",
                "code" => "oc"
            ],
            [
                "name_en" => "Ojibwe, Ojibwa",
                "native_name" => "ᐊᓂᔑᓈᐯᒧᐎᓐ",
                "code" => "oj"
            ],
            [
                "name_en" => "Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic",
                "native_name" => "ѩзыкъ словѣньскъ",
                "code" => "cu"
            ],
            [
                "name_en" => "Oromo",
                "native_name" => "Afaan Oromoo",
                "code" => "om"
            ],
            [
                "name_en" => "Oriya",
                "native_name" => "ଓଡ଼ିଆ",
                "code" => "or"
            ],
            [
                "name_en" => "Ossetian, Ossetic",
                "native_name" => "ирон æвзаг",
                "code" => "os"
            ],
            [
                "name_en" => "Panjabi, Punjabi",
                "native_name" => "ਪੰਜਾਬੀ, پنجابی‎",
                "code" => "pa"
            ],
            [
                "name_en" => "Pāli",
                "native_name" => "पाऴि",
                "code" => "pi"
            ],
            [
                "name_en" => "Persian",
                "native_name" => "فارسی",
                "code" => "fa"
            ],
            [
                "name_en" => "Polish",
                "native_name" => "polski",
                "code" => "pl"
            ],
            [
                "name_en" => "Pashto, Pushto",
                "native_name" => "پښتو",
                "code" => "ps"
            ],
            [
                "name_en" => "Portuguese",
                "native_name" => "Português",
                "code" => "pt"
            ],
            [
                "name_en" => "Quechua",
                "native_name" => "Runa Simi, Kichwa",
                "code" => "qu"
            ],
            [
                "name_en" => "Romansh",
                "native_name" => "rumantsch grischun",
                "code" => "rm"
            ],
            [
                "name_en" => "Kirundi",
                "native_name" => "kiRundi",
                "code" => "rn"
            ],
            [
                "name_en" => "Romanian, Moldavian, Moldovan",
                "native_name" => "română",
                "code" => "ro"
            ],
            [
                "name_en" => "Russian",
                "native_name" => "русский язык",
                "code" => "ru"
            ],
            [
                "name_en" => "Sanskrit (Saṁskṛta)",
                "native_name" => "संस्कृतम्",
                "code" => "sa"
            ],
            [
                "name_en" => "Sardinian",
                "native_name" => "sardu",
                "code" => "sc"
            ],
            [
                "name_en" => "Sindhi",
                "native_name" => "सिन्धी, سنڌي، سندھی‎",
                "code" => "sd"
            ],
            [
                "name_en" => "Northern Sami",
                "native_name" => "Davvisámegiella",
                "code" => "se"
            ],
            [
                "name_en" => "Samoan",
                "native_name" => "gagana faa Samoa",
                "code" => "sm"
            ],
            [
                "name_en" => "Sango",
                "native_name" => "yângâ tî sängö",
                "code" => "sg"
            ],
            [
                "name_en" => "Serbian",
                "native_name" => "српски језик",
                "code" => "sr"
            ],
            [
                "name_en" => "Scottish Gaelic; Gaelic",
                "native_name" => "Gàidhlig",
                "code" => "gd"
            ],
            [
                "name_en" => "Shona",
                "native_name" => "chiShona",
                "code" => "sn"
            ],
            [
                "name_en" => "Sinhala, Sinhalese",
                "native_name" => "සිංහල",
                "code" => "si"
            ],
            [
                "name_en" => "Slovak",
                "native_name" => "slovenčina",
                "code" => "sk"
            ],
            [
                "name_en" => "Slovene",
                "native_name" => "slovenščina",
                "code" => "sl"
            ],
            [
                "name_en" => "Somali",
                "native_name" => "Soomaaliga, af Soomaali",
                "code" => "so"
            ],
            [
                "name_en" => "Southern Sotho",
                "native_name" => "Sesotho",
                "code" => "st"
            ],
            [
                "name_en" => "Spanish; Castilian",
                "native_name" => "español, castellano",
                "code" => "es"
            ],
            [
                "name_en" => "Sundanese",
                "native_name" => "Basa Sunda",
                "code" => "su"
            ],
            [
                "name_en" => "Swahili",
                "native_name" => "Kiswahili",
                "code" => "sw"
            ],
            [
                "name_en" => "Swati",
                "native_name" => "SiSwati",
                "code" => "ss"
            ],
            [
                "name_en" => "Swedish",
                "native_name" => "svenska",
                "code" => "sv"
            ],
            [
                "name_en" => "Tamil",
                "native_name" => "தமிழ்",
                "code" => "ta"
            ],
            [
                "name_en" => "Telugu",
                "native_name" => "తెలుగు",
                "code" => "te"
            ],
            [
                "name_en" => "Tajik",
                "native_name" => "тоҷикӣ, toğikī, تاجیکی‎",
                "code" => "tg"
            ],
            [
                "name_en" => "Thai",
                "native_name" => "ไทย",
                "code" => "th"
            ],
            [
                "name_en" => "Tigrinya",
                "native_name" => "ትግርኛ",
                "code" => "ti"
            ],
            [
                "name_en" => "Tibetan Standard, Tibetan, Central",
                "native_name" => "བོད་ཡིག",
                "code" => "bo"
            ],
            [
                "name_en" => "Turkmen",
                "native_name" => "Türkmen, Түркмен",
                "code" => "tk"
            ],
            [
                "name_en" => "Tagalog",
                "native_name" => "Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔",
                "code" => "tl"
            ],
            [
                "name_en" => "Tswana",
                "native_name" => "Setswana",
                "code" => "tn"
            ],
            [
                "name_en" => "Tonga (Tonga Islands)",
                "native_name" => "faka Tonga",
                "code" => "to"
            ],
            [
                "name_en" => "Turkish",
                "native_name" => "Türkçe",
                "code" => "tr"
            ],
            [
                "name_en" => "Tsonga",
                "native_name" => "Xitsonga",
                "code" => "ts"
            ],
            [
                "name_en" => "Tatar",
                "native_name" => "татарча, tatarça, تاتارچا‎",
                "code" => "tt"
            ],
            [
                "name_en" => "Twi",
                "native_name" => "Twi",
                "code" => "tw"
            ],
            [
                "name_en" => "Tahitian",
                "native_name" => "Reo Tahiti",
                "code" => "ty"
            ],
            [
                "name_en" => "Uighur, Uyghur",
                "native_name" => "Uyƣurqə, ئۇيغۇرچە‎",
                "code" => "ug"
            ],
            [
                "name_en" => "Ukrainian",
                "native_name" => "українська",
                "code" => "uk"
            ],
            [
                "name_en" => "Urdu",
                "native_name" => "اردو",
                "code" => "ur"
            ],
            [
                "name_en" => "Uzbek",
                "native_name" => "zbek, Ўзбек, أۇزبېك‎",
                "code" => "uz"
            ],
            [
                "name_en" => "Venda",
                "native_name" => "Tshivenḓa",
                "code" => "ve"
            ],
            [
                "name_en" => "Vietnamese",
                "native_name" => "Tiếng Việt",
                "code" => "vi"
            ],
            [
                "name_en" => "Volapük",
                "native_name" => "Volapük",
                "code" => "vo"
            ],
            [
                "name_en" => "Walloon",
                "native_name" => "Walon",
                "code" => "wa"
            ],
            [
                "name_en" => "Welsh",
                "native_name" => "Cymraeg",
                "code" => "cy"
            ],
            [
                "name_en" => "Wolof",
                "native_name" => "Wollof",
                "code" => "wo"
            ],
            [
                "name_en" => "Western Frisian",
                "native_name" => "Frysk",
                "code" => "fy"
            ],
            [
                "name_en" => "Xhosa",
                "native_name" => "isiXhosa",
                "code" => "xh"
            ],
            [
                "name_en" => "Yiddish",
                "native_name" => "ייִדיש",
                "code" => "yi"
            ],
            [
                "name_en" => "Yoruba",
                "native_name" => "Yorùbá",
                "code" => "yo"
            ],
            [
                "name_en" => "Zhuang, Chuang",
                "native_name" => "Saɯ cueŋƅ, Saw cuengh",
                "code" => "za"
            ]
        ]);
    }
}
