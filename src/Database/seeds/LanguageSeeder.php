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
                "native_name" => "аҧсуа",
                "code" => "ab"
            ],
            [
                "native_name" => "Afaraf",
                "code" => "aa"
            ],
            [
                "native_name" => "Afrikaans",
                "code" => "af"
            ],
            [
                "native_name" => "Akan",
                "code" => "ak"
            ],
            [
                "native_name" => "Shqip",
                "code" => "sq"
            ],
            [
                "native_name" => "አማርኛ",
                "code" => "am"
            ],
            [
                "native_name" => "العربية",
                "code" => "ar"
            ],
            [
                "native_name" => "Aragonés",
                "code" => "an"
            ],
            [
                "native_name" => "Հայերեն",
                "code" => "hy"
            ],
            [
                "native_name" => "অসমীয়া",
                "code" => "as"
            ],
            [
                "native_name" => "авар мацӀ, магӀарул мацӀ",
                "code" => "av"
            ],
            [
                "native_name" => "avesta",
                "code" => "ae"
            ],
            [
                "native_name" => "aymar aru",
                "code" => "ay"
            ],
            [
                "native_name" => "azərbaycan dili",
                "code" => "az"
            ],
            [
                "native_name" => "bamanankan",
                "code" => "bm"
            ],
            [
                "native_name" => "башҡорт теле",
                "code" => "ba"
            ],
            [
                "native_name" => "euskara, euskera",
                "code" => "eu"
            ],
            [
                "native_name" => "Беларуская",
                "code" => "be"
            ],
            [
                "native_name" => "বাংলা",
                "code" => "bn"
            ],
            [
                "native_name" => "भोजपुरी",
                "code" => "bh"
            ],
            [
                "native_name" => "Bislama",
                "code" => "bi"
            ],
            [
                "native_name" => "bosanski jezik",
                "code" => "bs"
            ],
            [
                "native_name" => "brezhoneg",
                "code" => "br"
            ],
            [
                "native_name" => "български език",
                "code" => "bg"
            ],
            [
                "native_name" => "ဗမာစာ",
                "code" => "my"
            ],
            [
                "native_name" => "Català",
                "code" => "ca"
            ],
            [
                "native_name" => "Chamoru",
                "code" => "ch"
            ],
            [
                "native_name" => "нохчийн мотт",
                "code" => "ce"
            ],
            [
                "native_name" => "chiCheŵa, chinyanja",
                "code" => "ny"
            ],
            [
                "native_name" => "中文 (Zhōngwén), 汉语, 漢語",
                "code" => "zh"
            ],
            [
                "native_name" => "чӑваш чӗлхи",
                "code" => "cv"
            ],
            [
                "native_name" => "Kernewek",
                "code" => "kw"
            ],
            [
                "native_name" => "corsu, lingua corsa",
                "code" => "co"
            ],
            [
                "native_name" => "ᓀᐦᐃᔭᐍᐏᐣ",
                "code" => "cr"
            ],
            [
                "native_name" => "hrvatski",
                "code" => "hr"
            ],
            [
                "native_name" => "česky, čeština",
                "code" => "cs"
            ],
            [
                "native_name" => "dansk",
                "code" => "da"
            ],
            [
                "native_name" => "ދިވެހި",
                "code" => "dv"
            ],
            [
                "native_name" => "Nederlands, Vlaams",
                "code" => "nl"
            ],
            [
                "native_name" => "English",
                "code" => "en"
            ],
            [
                "native_name" => "Esperanto",
                "code" => "eo"
            ],
            [
                "native_name" => "eesti, eesti keel",
                "code" => "et"
            ],
            [
                "native_name" => "Eʋegbe",
                "code" => "ee"
            ],
            [
                "native_name" => "føroyskt",
                "code" => "fo"
            ],
            [
                "native_name" => "vosa Vakaviti",
                "code" => "fj"
            ],
            [
                "native_name" => "suomi, suomen kieli",
                "code" => "fi"
            ],
            [
                "native_name" => "français, langue française",
                "code" => "fr"
            ],
            [
                "native_name" => "Fulfulde, Pulaar, Pular",
                "code" => "ff"
            ],
            [
                "native_name" => "Galego",
                "code" => "gl"
            ],
            [
                "native_name" => "ქართული",
                "code" => "ka"
            ],
            [
                "native_name" => "Deutsch",
                "code" => "de"
            ],
            [
                "native_name" => "Ελληνικά",
                "code" => "el"
            ],
            [
                "native_name" => "Avañeẽ",
                "code" => "gn"
            ],
            [
                "native_name" => "ગુજરાતી",
                "code" => "gu"
            ],
            [
                "native_name" => "Kreyòl ayisyen",
                "code" => "ht"
            ],
            [
                "native_name" => "Hausa, هَوُسَ",
                "code" => "ha"
            ],
            [
                "native_name" => "עברית",
                "code" => "he"
            ],
            [
                "native_name" => "עברית",
                "code" => "iw"
            ],
            [
                "native_name" => "Otjiherero",
                "code" => "hz"
            ],
            [
                "native_name" => "हिन्दी, हिंदी",
                "code" => "hi"
            ],
            [
                "native_name" => "Hiri Motu",
                "code" => "ho"
            ],
            [
                "native_name" => "Magyar",
                "code" => "hu"
            ],
            [
                "native_name" => "Interlingua",
                "code" => "ia"
            ],
            [
                "native_name" => "Bahasa Indonesia",
                "code" => "id"
            ],
            [
                "native_name" => "Originally called Occidental; then Interlingue after WWII",
                "code" => "ie"
            ],
            [
                "native_name" => "Gaeilge",
                "code" => "ga"
            ],
            [
                "native_name" => "Asụsụ Igbo",
                "code" => "ig"
            ],
            [
                "native_name" => "Iñupiaq, Iñupiatun",
                "code" => "ik"
            ],
            [
                "native_name" => "Ido",
                "code" => "io"
            ],
            [
                "native_name" => "Íslenska",
                "code" => "is"
            ],
            [
                "native_name" => "Italiano",
                "code" => "it"
            ],
            [
                "native_name" => "ᐃᓄᒃᑎᑐᑦ",
                "code" => "iu"
            ],
            [
                "native_name" => "日本語 (にほんご／にっぽんご)",
                "code" => "ja"
            ],
            [
                "native_name" => "basa Jawa",
                "code" => "jv"
            ],
            [
                "native_name" => "kalaallisut, kalaallit oqaasii",
                "code" => "kl"
            ],
            [
                "native_name" => "ಕನ್ನಡ",
                "code" => "kn"
            ],
            [
                "native_name" => "Kanuri",
                "code" => "kr"
            ],
            [
                "native_name" => "कश्मीरी, كشميري‎",
                "code" => "ks"
            ],
            [
                "native_name" => "Қазақ тілі",
                "code" => "kk"
            ],
            [
                "native_name" => "ភាសាខ្មែរ",
                "code" => "km"
            ],
            [
                "native_name" => "Gĩkũyũ",
                "code" => "ki"
            ],
            [
                "native_name" => "Ikinyarwanda",
                "code" => "rw"
            ],
            [
                "native_name" => "кыргыз тили",
                "code" => "ky"
            ],
            [
                "native_name" => "коми кыв",
                "code" => "kv"
            ],
            [
                "native_name" => "KiKongo",
                "code" => "kg"
            ],
            [
                "native_name" => "한국어 (韓國語), 조선말 (朝鮮語)",
                "code" => "ko"
            ],
            [
                "native_name" => "Kurdî, كوردی‎",
                "code" => "ku"
            ],
            [
                "native_name" => "Kuanyama",
                "code" => "kj"
            ],
            [
                "native_name" => "latine, lingua latina",
                "code" => "la"
            ],
            [
                "native_name" => "Lëtzebuergesch",
                "code" => "lb"
            ],
            [
                "native_name" => "Luganda",
                "code" => "lg"
            ],
            [
                "native_name" => "Limburgs",
                "code" => "li"
            ],
            [
                "native_name" => "Lingála",
                "code" => "ln"
            ],
            [
                "native_name" => "ພາສາລາວ",
                "code" => "lo"
            ],
            [
                "native_name" => "lietuvių kalba",
                "code" => "lt"
            ],
            [
                "native_name" => "",
                "code" => "lu"
            ],
            [
                "native_name" => "latviešu valoda",
                "code" => "lv"
            ],
            [
                "native_name" => "Gaelg, Gailck",
                "code" => "gv"
            ],
            [
                "native_name" => "македонски јазик",
                "code" => "mk"
            ],
            [
                "native_name" => "Malagasy fiteny",
                "code" => "mg"
            ],
            [
                "native_name" => "bahasa Melayu, بهاس ملايو‎",
                "code" => "ms"
            ],
            [
                "native_name" => "മലയാളം",
                "code" => "ml"
            ],
            [
                "native_name" => "Malti",
                "code" => "mt"
            ],
            [
                "native_name" => "te reo Māori",
                "code" => "mi"
            ],
            [
                "native_name" => "मराठी",
                "code" => "mr"
            ],
            [
                "native_name" => "Kajin M̧ajeļ",
                "code" => "mh"
            ],
            [
                "native_name" => "монгол",
                "code" => "mn"
            ],
            [
                "native_name" => "Ekakairũ Naoero",
                "code" => "na"
            ],
            [
                "native_name" => "Diné bizaad, Dinékʼehǰí",
                "code" => "nv"
            ],
            [
                "native_name" => "Norsk bokmål",
                "code" => "nb"
            ],
            [
                "native_name" => "isiNdebele",
                "code" => "nd"
            ],
            [
                "native_name" => "नेपाली",
                "code" => "ne"
            ],
            [
                "native_name" => "Owambo",
                "code" => "ng"
            ],
            [
                "native_name" => "Norsk nynorsk",
                "code" => "nn"
            ],
            [
                "native_name" => "Norsk",
                "code" => "no"
            ],
            [
                "native_name" => "ꆈꌠ꒿ Nuosuhxop",
                "code" => "ii"
            ],
            [
                "native_name" => "isiNdebele",
                "code" => "nr"
            ],
            [
                "native_name" => "Occitan",
                "code" => "oc"
            ],
            [
                "native_name" => "ᐊᓂᔑᓈᐯᒧᐎᓐ",
                "code" => "oj"
            ],
            [
                "native_name" => "ѩзыкъ словѣньскъ",
                "code" => "cu"
            ],
            [
                "native_name" => "Afaan Oromoo",
                "code" => "om"
            ],
            [
                "native_name" => "ଓଡ଼ିଆ",
                "code" => "or"
            ],
            [
                "native_name" => "ирон æвзаг",
                "code" => "os"
            ],
            [
                "native_name" => "ਪੰਜਾਬੀ, پنجابی‎",
                "code" => "pa"
            ],
            [
                "native_name" => "पाऴि",
                "code" => "pi"
            ],
            [
                "native_name" => "فارسی",
                "code" => "fa"
            ],
            [
                "native_name" => "polski",
                "code" => "pl"
            ],
            [
                "native_name" => "پښتو",
                "code" => "ps"
            ],
            [
                "native_name" => "Português",
                "code" => "pt"
            ],
            [
                "native_name" => "Runa Simi, Kichwa",
                "code" => "qu"
            ],
            [
                "native_name" => "rumantsch grischun",
                "code" => "rm"
            ],
            [
                "native_name" => "kiRundi",
                "code" => "rn"
            ],
            [
                "native_name" => "română",
                "code" => "ro"
            ],
            [
                "native_name" => "русский язык",
                "code" => "ru"
            ],
            [
                "native_name" => "संस्कृतम्",
                "code" => "sa"
            ],
            [
                "native_name" => "sardu",
                "code" => "sc"
            ],
            [
                "native_name" => "सिन्धी, سنڌي، سندھی‎",
                "code" => "sd"
            ],
            [
                "native_name" => "Davvisámegiella",
                "code" => "se"
            ],
            [
                "native_name" => "gagana faa Samoa",
                "code" => "sm"
            ],
            [
                "native_name" => "yângâ tî sängö",
                "code" => "sg"
            ],
            [
                "native_name" => "српски језик",
                "code" => "sr"
            ],
            [
                "native_name" => "Gàidhlig",
                "code" => "gd"
            ],
            [
                "native_name" => "chiShona",
                "code" => "sn"
            ],
            [
                "native_name" => "සිංහල",
                "code" => "si"
            ],
            [
                "native_name" => "slovenčina",
                "code" => "sk"
            ],
            [
                "native_name" => "slovenščina",
                "code" => "sl"
            ],
            [
                "native_name" => "Soomaaliga, af Soomaali",
                "code" => "so"
            ],
            [
                "native_name" => "Sesotho",
                "code" => "st"
            ],
            [
                "native_name" => "español, castellano",
                "code" => "es"
            ],
            [
                "native_name" => "Basa Sunda",
                "code" => "su"
            ],
            [
                "native_name" => "Kiswahili",
                "code" => "sw"
            ],
            [
                "native_name" => "SiSwati",
                "code" => "ss"
            ],
            [
                "native_name" => "svenska",
                "code" => "sv"
            ],
            [
                "native_name" => "தமிழ்",
                "code" => "ta"
            ],
            [
                "native_name" => "తెలుగు",
                "code" => "te"
            ],
            [
                "native_name" => "тоҷикӣ, toğikī, تاجیکی‎",
                "code" => "tg"
            ],
            [
                "native_name" => "ไทย",
                "code" => "th"
            ],
            [
                "native_name" => "ትግርኛ",
                "code" => "ti"
            ],
            [
                "native_name" => "བོད་ཡིག",
                "code" => "bo"
            ],
            [
                "native_name" => "Türkmen, Түркмен",
                "code" => "tk"
            ],
            [
                "native_name" => "Wikang Tagalog, ᜏᜒᜃᜅ᜔ ᜆᜄᜎᜓᜄ᜔",
                "code" => "tl"
            ],
            [
                "native_name" => "Setswana",
                "code" => "tn"
            ],
            [
                "native_name" => "faka Tonga",
                "code" => "to"
            ],
            [
                "native_name" => "Türkçe",
                "code" => "tr"
            ],
            [
                "native_name" => "Xitsonga",
                "code" => "ts"
            ],
            [
                "native_name" => "татарча, tatarça, تاتارچا‎",
                "code" => "tt"
            ],
            [
                "native_name" => "Twi",
                "code" => "tw"
            ],
            [
                "native_name" => "Reo Tahiti",
                "code" => "ty"
            ],
            [
                "native_name" => "Uyƣurqə, ئۇيغۇرچە‎",
                "code" => "ug"
            ],
            [
                "native_name" => "українська",
                "code" => "uk"
            ],
            [
                "native_name" => "اردو",
                "code" => "ur"
            ],
            [
                "native_name" => "zbek, Ўзбек, أۇزبېك‎",
                "code" => "uz"
            ],
            [
                "native_name" => "Tshivenḓa",
                "code" => "ve"
            ],
            [
                "native_name" => "Tiếng Việt",
                "code" => "vi"
            ],
            [
                "native_name" => "Volapük",
                "code" => "vo"
            ],
            [
                "native_name" => "Walon",
                "code" => "wa"
            ],
            [
                "native_name" => "Cymraeg",
                "code" => "cy"
            ],
            [
                "native_name" => "Wollof",
                "code" => "wo"
            ],
            [
                "native_name" => "Frysk",
                "code" => "fy"
            ],
            [
                "native_name" => "isiXhosa",
                "code" => "xh"
            ],
            [
                "native_name" => "ייִדיש",
                "code" => "yi"
            ],
            [
                "native_name" => "Yorùbá",
                "code" => "yo"
            ],
            [
                "native_name" => "Saɯ cueŋƅ, Saw cuengh",
                "code" => "za"
            ]
        ]);
    }
}
