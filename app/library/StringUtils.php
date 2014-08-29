<?php

class StringUtils {
    // 参考: http://wada811.blogspot.com/2013/03/best-email-format-check-regex-in-php.html
    public static function addEmailAnchor($str) {
        $wsp            = '[\x20\x09]';                         // 半角空白と水平タブ
        $vchar          = '[\x21-\x7e]';                        // ASCIIコードの ! から ~
        $quoted_pair    = "\\\\(?:{$vchar}|{$wsp})";            // \ を前につけた quoted-pair 形式なら \ と " が使用可
        $qtext          = '[\x21\x23-\x5b\x5d-\x7e]';           // $vchar から  " (\x22) と \ (\x5c) を抜いたもの
        $qcontent       = "(?:{$qtext}|{$quoted_pair})";        // quoted-string 形式の条件分岐
        $quoted_string  = "\"{$qcontent}+\"";                   // " で囲まれた quoted-string 形式
        $atext          = '[a-zA-Z0-9!#$%&\'*+\-\/\=?^_`{|}~]'; // 通常メールアドレスに使用可能な文字
        $dot_atom       = "{$atext}+(?:[.]{$atext}+)*";         // ドットが連続しない RFC 準拠形式をループ展開で構築
        $local_part     = "(?:{$dot_atom}|{$quoted_string})";   // local-part は dot-atom 形式または quoted-string 形式
        $alnum          = '[a-zA-Z0-9]';                        // domain の先頭は英数字
        $sub_domain     = "{$alnum}+(?:-{$alnum}+)*";           // hyphenated alnum をループ展開で構築
        // ハイフンとドットが連続しないように $sub_domain をループ展開
        $domain         = "(?:{$sub_domain})+(?:[.](?:{$sub_domain})+)+";

        // local-part 部と domain 部を合成して判定用の正規表現とする
        $regexp         = "{$local_part}[@]{$domain}";

        return preg_replace("/({$regexp})/", '<a href="mailto:${1}">${1}</a>', $str);
    }

    public static function addUrlAnchor($str) {
        $regexp = '/https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+$,%#]+/';
        return preg_replace_callback(
            $regexp,
            // コールバックを無名関数で定義
            function ($matches) {
                $replaced_str = "<a href=\"{$matches[0]}\" target=\"_blank\">";

                if (preg_match('/\.(jpg|jpeg|gif|bmp|png)\z/', $matches[0])) {
                    $replaced_str .= "<img src=\"{$matches[0]}\"/>";
                } else {
                    $replaced_str .= "{$matches[0]}";
                }

                return $replaced_str . "</a>";
            },
            $str
        );
    }
}
