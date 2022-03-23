<?php

namespace FakerChineseLorem\Provider\zh_CN;

class Lorem extends \Faker\Provider\Lorem
{
    /**
     * @var array $wordList High-frequency single character of Chinese (simplified)
     */
    protected static $wordList = array(
        '的', '一', '是', '在', '不', '了', '有', '和', '人', '這',
        '中', '大', '為', '上', '個', '國', '我', '以', '要', '他',
        '時', '來', '用', '們', '生', '到', '作', '地', '於', '出',
        '就', '分', '對', '成', '會', '可', '主', '發', '年', '動',
        '同', '工', '也', '能', '下', '過', '子', '說', '產', '種',
        '面', '而', '方', '後', '多', '定', '行', '學', '法', '所',
        '民', '得', '經', '十', '三', '之', '進', '著', '等', '部',
        '度', '家', '電', '力', '裡', '如', '水', '化', '高', '自',
        '二', '理', '起', '小', '物', '現', '實', '加', '量', '都',
        '兩', '體', '制', '機', '當', '使', '點', '從', '業', '本',
        '去', '把', '性', '好', '應', '開', '它', '合', '還', '因',
        '由', '其', '些', '然', '前', '外', '天', '政', '四', '日',
        '那', '社', '義', '事', '平', '形', '相', '全', '表', '間',
        '樣', '與', '關', '各', '重', '新', '線', '內', '數', '正',
        '心', '反', '你', '明', '看', '原', '又', '麼', '利', '比',
        '或', '但', '質', '氣', '第', '向', '道', '命', '此', '變',
        '條', '只', '沒', '結', '解', '問', '意', '建', '月', '公',
        '無', '系', '軍', '很', '情', '者', '最', '立', '代', '想',
        '已', '通', '並', '提', '直', '題', '黨', '程', '展', '五',
        '果', '料', '象', '員', '革', '位', '入', '常', '文', '總',
        '次', '品', '式', '活', '設', '及', '管', '特', '件', '長',
        '求', '老', '頭', '基', '資', '邊', '流', '路', '級', '少',
        '圖', '山', '統', '接', '知', '較', '將', '組', '見', '計',
        '別', '她', '手', '角', '期', '根', '論', '運', '農', '指',
        '幾', '九', '區', '強', '放', '決', '西', '被', '幹', '做',
        '必', '戰', '先', '回', '則', '任', '取', '據', '處', '隊',
        '南', '給', '色', '光', '門', '即', '保', '治', '北', '造',
        '百', '規', '熱', '領', '七', '海', '口', '東', '導', '器',
        '壓', '志', '世', '金', '增', '爭', '濟', '階', '油', '思',
        '術', '極', '交', '受', '聯', '什', '認', '六', '共', '權',
        '收', '證', '改', '清', '己', '美', '再', '採', '轉', '更',
        '單', '風', '切', '打', '白', '教', '速', '花', '帶', '安',
        '場', '身', '車', '例', '真', '務', '具', '萬', '每', '目',
        '至', '達', '走', '積', '示', '議', '聲', '報', '鬥', '完',
        '類', '八', '離', '華', '名', '確', '才', '科', '張', '信',
        '馬', '節', '話', '米', '整', '空', '元', '況', '今', '集',
        '溫', '傳', '土', '許', '步', '群', '廣', '石', '記', '需',
        '段', '研', '界', '拉', '林', '律', '叫', '且', '究', '觀',
        '越', '織', '裝', '影', '算', '低', '持', '音', '眾', '書',
        '布', '复', '容', '兒', '須', '際', '商', '非', '驗', '連',
        '斷', '深', '難', '近', '礦', '千', '週', '委', '素', '技',
        '備', '半', '辦', '青', '省', '列', '習', '響', '約', '支',
        '般', '史', '感', '勞', '便', '團', '往', '酸', '歷', '市',
        '克', '何', '除', '消', '構', '府', '稱', '太', '準', '精',
        '值', '號', '率', '族', '維', '劃', '選', '標', '寫', '存',
        '候', '毛', '親', '快', '效', '斯', '院', '查', '江', '型',
        '眼', '王', '按', '格', '養', '易', '置', '派', '層', '片',
        '始', '卻', '專', '狀', '育', '廠', '京', '識', '適', '屬',
        '圓', '包', '火', '住', '調', '滿', '縣', '局', '照', '參',
        '紅', '細', '引', '聽', '該', '鐵', '價', '嚴', '龍', '飛',
    );

    protected static $encoding = 'UTF-8';

    /**
     * Generate a random single Chinese character
     * @example '的' '一' '是'
     * @return string
     */
    public static function char()
    {
        return static::randomElement(static::$wordList);
    }

    /**
     * Generate an array of random characters
     *
     * @example array('的', '一', '是')
     * @param  integer      $nb     how many characters to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function chars($nb = 3, $asText = false)
    {
        $chars = static::randomElements(static::$wordList, $nb);
        return $asText ? implode('', $chars) : $chars;
    }

    /**
     * Generate a random word
     * A chinese word usually contains 1 - 4 single character.
     *
     * Character numbers : Frequency
     * 1 : 10%
     * 2 : 60%
     * 3 : 10%
     * 4 : 20%
     * The generated words may be unreadable by people.
     *
     * Usage:
     *     Lorem::word();
     *     Lorem::word(2); // generate word contains exact 2 chars
     *
     * @param  integer  $nb  (optional) how many characters the word contains
     * @example '的' '的一' '的一是' '的一是在'
     * @return string
     */
    public static function word()
    {
        $num_args = func_num_args();
        if ($num_args >= 1) {
            $nb = func_get_arg(0);
            if ($nb > 7) {
                throw new \InvalidArgumentException('Chinese word must contain no more than 7 characters');
            }
        } else {
            $nb = static::randomizeCharacterNumber();
        }
        return static::chars($nb, true);
    }

    /**
     * Generate an array of random words
     *
     * @example array('的一', '的一是', '的一是在')
     * @param  integer      $nb     how many words to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function words($nb = 3, $asText = false)
    {
        $words = array();
        for ($i=0; $i < $nb; $i++) {
            $words[] = static::word();
        }

        // No space between Chinese words in sentences
        return $asText ? implode('', $words) : $words;
    }

    /**
     * Generate a random sentence
     *
     * @example '的一是在不了有。'
     * @param integer $nbWords         around how many words the sentence should contain
     * @param boolean $variableNbWords set to false if you want exactly $nbWords returned,
     *                                  otherwise $nbWords may vary by +/-40% with a minimum of 1
     * @return string
     */
    public static function sentence($nbWords = 6, $variableNbWords = true)
    {
        if ($nbWords <= 0) {
            return '';
        }
        if ($variableNbWords) {
            $nbWords = self::randomizeNbElements($nbWords);
        }

        $sentence = static::words($nbWords, true);
        // Chinese characters do not need ucfirst

        return $sentence . '。';
    }

    /**
     * Generate an array of sentences
     *
     * @example array('的一是在不了有。', '和人这中大。')
     * @param  integer      $nb     how many sentences to return
     * @param  bool         $asText if true the sentences are returned as one string
     * @return array|string
     */
    public static function sentences($nb = 3, $asText = false)
    {
        $sentences = array();
        for ($i=0; $i < $nb; $i++) {
            $sentences[] = static::sentence();
        }

        // No space between sentence in Chinese
        return $asText ? implode('', $sentences) : $sentences;
    }

    /**
     * Generate a single paragraph
     *
     * @example '的一是在不了有。和人这中大。为上个国我以。'
     * @param integer $nbSentences         around how many sentences the paragraph should contain
     * @param boolean $variableNbSentences set to false if you want exactly $nbSentences returned,
     *                                      otherwise $nbSentences may vary by +/-40% with a minimum of 1
     * @return string
     */
    public static function paragraph($nbSentences = 3, $variableNbSentences = true)
    {
        if ($nbSentences <= 0) {
            return '';
        }
        if ($variableNbSentences) {
            $nbSentences = self::randomizeNbElements($nbSentences);
        }

        return static::sentences($nbSentences, true);
    }

    /**
     * Generate an array of paragraphs
     *
     * @example array($paragraph1, $paragraph2, $paragraph3)
     * @param  integer      $nb     how many paragraphs to return
     * @param  bool         $asText if true the paragraphs are returned as one string, separated by two newlines
     * @return array|string
     */
    public static function paragraphs($nb = 3, $asText = false)
    {
        $paragraphs = array();
        for ($i=0; $i < $nb; $i++) {
            $paragraphs []= static::paragraph();
        }

        return $asText ? implode("\n\n", $paragraphs) : $paragraphs;
    }

    /**
     * Generate a text string.
     * Depending on the $maxNbChars, returns a string made of words, sentences, or paragraphs.
     *
     * @example '的一是。' '的一是在不了有。' '的一是在不了有。和人这中大。为上个国我以。'
     *
     * @param  integer $maxNbChars Maximum number of characters the text should contain (minimum 2).
     *                             CAUTION: 1 Chinese character == 3 bytes (UTF-8),
     *                             the parameter is maximum number of CHARACTERS, not number of BYTES.
     *
     * @return string
     */
    public static function text($maxNbChars = 200)
    {
        if ($maxNbChars < 2) {
            throw new \InvalidArgumentException('text() can only generate text of at least 2 characters');
        }

        $type = ($maxNbChars < 15) ? 'word' : (($maxNbChars < 100) ? 'sentence' : 'paragraph');

        $text = array();
        while (empty($text)) {
            $size = 0;

            // until $maxNbChars is reached
            while ($size < $maxNbChars) {
                $word   = static::$type();
                $text[] = $word;

                $size += static::strlen($word);
            }

            array_pop($text);
        }

        if ($type === 'word') {
            // end sentence with full stop
            $text[count($text) - 1] .= '。';
        }

        return implode('', $text);
    }

    /**
     * Character numbers : Frequency
     * 1 : 10%
     * 2 : 60%
     * 3 : 10%
     * 4 : 20%
     * @return int
     */
    protected static function randomizeCharacterNumber()
    {
        static $characterNumber = array(
            1,
            2, 2, 2, 2, 2, 2,
            3,
            4, 4,
        );
        return $characterNumber[static::numberBetween(0, count($characterNumber) - 1)];
    }

    protected static function strlen($str)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str, static::$encoding);
        } elseif (function_exists('preg_match_all')) {
            /** @link http://php.net/manual/en/function.mb-strlen.php#87114 */
            return preg_match_all("/.{1}/us", $str, $dummy);
        } else {
            // CAUTION: Only for Chinese UTF-8 characters.
            return (int)(self::strlen($str) / 3);
        }
    }
}
