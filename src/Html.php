<?php

namespace Markup;

class Html {
    private $tag;
    private $attributes;
    private $inside;

    public function __construct($tag, $attributes = [], $inside = null, $alwaysClose = false) {
        $this->tag = $tag;
        $this->attributes = $attributes;
        $this->inside = $inside;
        $this->alwaysClose = $alwaysClose;
    }

    /**
     * Erstellt ein Objekt und gibt es als String aus.
     * Wird ein $inside angegeben, wird dieses eingefügt; gefolgt vom closing Tag
     *
     * @param string $tag String des Tags
     * @param array $attributes Array mit Attributen
     * @param string $inside Inneres Element
     * @param bool $alwaysClose erstellt auch ohne $inside einen closing Tag
     * @return string
     */
    public static function createTag($tag, $attributes = [], $inside = null, $alwaysClose = false) {
        $html = new Html($tag, $attributes, $inside, $alwaysClose);
        if($html->inside == null && $html->alwaysClose === false) {
            return $html->toString();
        }

        return $html->toString() . $html->inside . $html->closingTag();

    }

    /**
     * Erstellt einen String aus dem Objekt
     * @return string
     */
    public function toString() {
        return '<' . $this->tag . $this->attributesToString() . '>';
    }

    /**
     * Erstellt einen String mit den Attributen eines Tags
     * @param array $attributes
     * @return string
     */
    private function attributesToString() {
        $output = '';
        foreach($this->attributes as $key => $val) {
            $output .= $this->attributeToString($key, $val);
        }
        return $output;
    }

    /**
     * Erstellt ein Attribut aus Bezeichnung und Wert mit vorangehendem Leerzeichen
     * @param $key
     * @param $val
     * @return string
     */
    private function attributeToString($key, $val) {
        if($val === NULL || $val === FALSE)
            return '';
        if(is_string($key)) {
            return ' ' . $key . '="' . $val . '"';
        } else {
            return ' ' . $val;
        }
    }

    /**
     * Erstellt schließenden Tag
     * @return string
     */
    private function closingTag() {
        return '</' . $this->tag . '>';
    }
}